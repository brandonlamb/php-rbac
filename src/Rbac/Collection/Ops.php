<?php
namespace Rbac\Collection;

use Rbac\Manager,
	Rbac\AbstractCollection,
	Rbac\CollectionInterface;

/**
 * This class loads all allowed operations based on give identity,
 * joining on the tables for roles and tasks.
 */
class Ops extends AbstractCollection implements CollectionInterface
{
	const ITEM_CLASS = '\\Rbac\\Op';

	/** @var string */
	protected $cacheKey = 'Rbac.Collection.Ops.identity.';

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
		$sql = "SELECT DISTINCT ao.name AS item_name, ao.id AS item_id, ao.description AS item_desc
FROM acl_op ao
JOIN acl_task_op ato ON (ao.id = ato.op_id)
JOIN acl_role_task art ON (ato.task_id = art.task_id)
JOIN acl_role ar ON (ar.id = art.role_id)
JOIN acl_user_role aur ON (aur.role_id = art.role_id)
WHERE aur.user_id = ?
ORDER BY item_name ASC";

		$stmt = $this->manager->connection()->prepare($sql);
		$stmt->execute(array($this->identity));
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		// Save to cache
		$this->manager->getCache() && $this->manager->getCache()->set($this->cacheKey . $this->identity, $rows, $this->cacheTtl);

		return $this->parse(static::ITEM_CLASS, $rows);
	}
}