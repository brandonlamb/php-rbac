<?php
namespace Rbac\Collection;

use Rbac\Manager,
	Rbac\AbstractCollection,
	Rbac\CollectionInterface;

/**
 * This class loads all roles based on give identity
 */
class Roles extends AbstractCollection implements CollectionInterface
{
	const ITEM_CLASS = '\\Rbac\\Role';

	/** @var string */
	protected $cacheKey = 'Rbac.Collection.Roles.identity.';

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
		$sql = "SELECT DISTINCT ar.name AS item_name, ar.id AS item_id, ar.description AS item_desc
FROM acl_role ar
JOIN acl_user_role aur ON (aur.role_id = ar.id)
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