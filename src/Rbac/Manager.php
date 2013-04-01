<?php
namespace Rbac;

class Manager
{
	/** @var \Pdo */
	protected $conn;

	/** @var CacheCache\Cache */
	protected $cache;

	/** @var bool */
	protected $debug;

	/** @var ops */
	protected $ops;

	/**
	 * Constructor
	 * @param PDO $conn
	 */
	public function __construct(\Pdo $conn)
	{
		$this->conn		= $conn;
		$this->debug	= false;
	}

	/**
	 * Get/set pdo connection
	 * @param \PDO $conn
	 * @return \PDO
	 */
	public function connection(\PDO $conn = null)
	{
		null !== $conn && $this->conn = $conn;
		return $this->conn;
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
	 * Check if operation access is allowed
	 * @param string $access
	 * @param \Rbac\CollectionInterface $collection
	 * @return bool
	 */
	public function isAllowed($access, CollectionInterface $collection)
	{
		return $collection->isAllowed($access);
	}
}