<?php
namespace Rbac;

/**
 * This class loads all allowed operations based on give identity,
 * joining on the tables for roles and tasks.
 */
class UserOps
{
	/** @var int */
	protected $identity;

	/** @var array */
	protected $ops;

	/** @var string */
	protected $cacheKey = 'Rbac.UserOps.identity.';

	/** @var int */
	protected $cacheTtl = 120;

	/**
	 * Constructor
	 * @param int $identity
	 * @param array $ops
	 */
	public function __construct(Manager $manager, $id = 0, array $ops = array())
	{
		$this->manager = $manager;
		$this->setIdentity($id);
		!empty($ops) && $this->ops = $this->parseOps($ops);
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
	 * Get ops array
	 * @return array
	 */
	public function ops()
	{
		return $this->ops;
	}

	/**
	 * Check access
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
	protected function getOps()
	{
		// Get results from cache if they exist
		$this->manager->getCache() && $rows = $this->manager->getCache()->get($this->cacheKey . $this->identity);
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

		$stmt = $this->manager->connection()->prepare($sql);
		$stmt->execute(array($this->identity));
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		// Save to cache
		$this->manager->getCache() && $this->manager->getCache()->set($this->cacheKey . $this->identity, $rows, $this->cacheTtl);

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