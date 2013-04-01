php-rbac
========

PHP Role Based Access Control Library

Usage
=====

```
$rbac = new \Rbac\Manager($pdo);
$rbac->setIdentity(123);

// Set cache object using CacheCache library
$cache = $cacheManager->get('cacheMemcached');
$rbac->setCache($cache);

// module.controller.action (operation name)
if (!$rbac->checkAccess('default.contact.submit')) {
	throw new \Exception('Not authorized');
}
```