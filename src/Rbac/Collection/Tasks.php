<?php
namespace Rbac\Collection;

use Rbac\Manager,
	Rbac\AbstractCollection,
	Rbac\CollectionInterface;

/**
 * This class loads all allowed tasks based on give, identity,
 * joining on the tables for roles and tasks.
 */
class Tasks extends AbstractCollection implements CollectionInterface
{
	const ITEM_CLASS = '\\Rbac\\Task';

	/** @var string */
	protected $cacheKey = 'Rbac.Collection.Tasks.identity.';

	/** @var int */
	protected $cacheTtl = 120;

	/**
	 * Fetch all allowed operatations for user
	 * @return array
	 */
	protected function getData()
	{
		// Get results from cache if they exist
		$this->manager->getCache() && $rows = $this->manager->getCache()->get($this->cacheKey . $this->identity);
		if (is_array($rows) && count($rows) > 0) {
			return $this->parse(static::ITEM_CLASS, $rows);
		}

		// Nothing found in cache, or cached array is empty, lookup from db
		$sql = "SELECT DISTINCT at.name AS task_name, at.id AS task_id, at.description AS task_desc
FROM acl_task at
JOIN acl_task_op ato ON (at.id = ato.task_id)
JOIN acl_role_task art ON (ato.task_id = art.task_id)
JOIN acl_role ar ON (ar.id = art.role_id)
JOIN acl_user_role aur ON (aur.role_id = art.role_id)
WHERE aur.user_id = ?
ORDER BY task_name ASC";

		$stmt = $this->manager->connection()->prepare($sql);
		$stmt->execute(array($this->identity));
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		// Save to cache
		$this->manager->getCache() && $this->manager->getCache()->set($this->cacheKey . $this->identity, $rows, $this->cacheTtl);

		return $this->parse(static::ITEM_CLASS, $rows);
	}
}