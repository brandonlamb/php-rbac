<?php
namespace Rbac;

class Manager
{
	/** @var \Pdo */
	protected $pdo;

	/** @var CacheCache\Cache */
	protected $cache;

	/** @var bool */
	protected $debug;

	/** @var int */
	protected $identity;

	/** @var ops */
	protected $ops;

	/** @var string */
	protected $cacheKey = 'rbac.user-ops.';

	/** @var int */
	protected $cacheTtl = 120;

	public function __construct(\Pdo $pdo)
	{
		$this->pdo		= $pdo;
		$this->debug	= false;
		$this->identity	= 0;
	}

	/**
	 * Set/get debug flag
	 * @param bool $debug
	 * @return bool
	 */
	public function debug($debug = null)
	{
		null !== $debug && $this->debug = (bool) $debug;
		return (bool) $this->debug;
	}

	/**
	 * Set user identity
	 * @param int $identity
	 * @return $this
	 */
	public function setIdentity($identity)
	{
		$this->identity = (int) $identity;
		return $this;
	}

	/**
	 * Get the user id
	 * @return int
	 */
	public function getIdentity()
	{
		return (int) $this->identity;
	}

	/**
	 * Set the cache object
	 * @param CacheCache\Cache
	 * @return $this
	 */
	public function setCache(\CacheCache\Cache $cache)
	{
		$this->cache = $cache;
		return $this->cache;
	}

	/**
	 * Return cache object
	 * @return CacheCache\Cache
	 */
	public function getCache()
	{
		return $this->cache;
	}

	/**
	 * Clear cache object
	 * @return $this
	 */
	public function clearCache()
	{
		$this->cache = null;
		return $this;
	}

	/**
	 * Check if access is allowed
	 * @param string $access
	 * @return bool
	 */
	public function checkAccess($access)
	{
		null === $this->ops && $this->ops = $this->getOps();
		return isset($this->ops[$access]);
	}

	/**
	 * Fetch all allowed operatations for user
	 * @return array
	 */
	public function getOps()
	{
		// Get results from cache if they exist
		$this->cache && $rows = $this->cache->get($this->cacheKey . $this->identity);
		if (is_array($rows) && count($rows) > 0) {
			return $this->parseOps($rows);
		}

		// Nothing found in cache, or cached array is empty, lookup from db
		$sql = "SELECT DISTINCT ao.name AS op_name, ao.id AS op_id, ao.description AS op_desc
FROM acl_op ao
JOIN acl_task_op ato ON (ao.id = ato.op_id)
JOIN acl_role_task art ON (ato.task_id = art.task_id)
JOIN acl_role ar ON (ar.id = art.role_id)
JOIN acl_user_role aur ON (aur.role_id = art.role_id)
WHERE aur.user_id = ?
ORDER BY op_name ASC";

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array($this->identity));
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		// Save to cache
		$this->cache && $this->cache->set($this->cacheKey . $this->identity, $rows, $this->cacheTtl);

		return $this->parseOps($rows);
	}

	/**
	 * @param array $rows
	 * @return array
	 */
	protected function parseOps(array $rows = array())
	{
		$ops = array();
		foreach ($rows as $row) {
			$op = new Op($row['op_id'], $row['op_name'], $row['op_desc']);
			$ops[$op->name()] = $op;
		}

		return $ops;
	}
}