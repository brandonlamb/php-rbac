php-rbac
========

PHP Role Based Access Control Library

Requirements
============
CacheCache library (loaded via composer) if you want caching

Usage
=====

```
// Create new rbac manager object
$manager = new \Rbac\Manager($pdo);

// Enable/disable debug mode
$manager->debug(true);

// Set cache object using CacheCache library
$cache = $cacheManager->get('cacheMemcached');
$manager->setCache($cache);

// Create new operations collection, passing the rbac manager and user identity
$ops = new \Rbac\Collection\Ops($manager, $user->id);

// Create new tasks collection, passing the rbac manager and user identity
$tasks = new \Rbac\Collection\Tasks($manager, $user->id);

// Allow access when srbac is in debug mode
if ($manager->debug() === true) { return true; }

// Check if access to operation is allowed module.controller.action (operation name)
if (!$manager->isAllowed('default.contact.submit', $ops)) {
	throw new \Exception('Not authorized to operation');
}

// Check if access to task is allowed module@controller
if (!$manager->isAllowed('default@contact', $tasks)) {
	throw new \Exception('Not authorized to task');
}
```

Acl Operations
==============

The naming convention is open ended. No helper methods are currently provided to generate operation name/ids. The convention in the usage example is $module.$controller.$action, but you can use whatever format you want. The SRBAC extension for Yii uses a "$module@$controller$action" format for example.