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

// Create new UserOps object, passing the rbac manager and user identity
$userOps = new \Rbac\UserOps($manager, $user->id);

// Allow access when srbac is in debug mode
if ($manager->debug() === true) { return true; }

// module.controller.action (operation name)
if (!$manager->checkAccess('default.contact.submit', $userOps)) {
	throw new \Exception('Not authorized');
}
```

Acl Operations
==============

The naming convention is open ended. No helper methods are currently provided to generate operation name/ids. The convention in the usage example is $module.$controller.$action, but you can use whatever format you want. The SRBAC extension for Yii uses a "$module@$controller$action" format for example.