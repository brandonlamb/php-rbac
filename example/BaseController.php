<?php
/**
 * @package Default module
 */
namespace Default\Controller;

class BaseController extends Controller
{
	/**
	 * Setup global options for extending controllers
	 */
	public function beforeDispatch()
	{
		parent::beforeDispatch();
		$di = $this->getDI();
		$router = $di->getShared('router');

		$access = strtolower($router->getModuleName() . '.' . $router->getControllerName() . '.' . $router->getActionName());

		// Always allow access if $access is in the allowedAccess array
		if (in_array($access, $this->allowedAccess())) { return true; }

		// Get rbac and user object
		$cacheManager = $di->getShared('cacheManager');
		$user = $di->getShared('user');
		$manager = $di->getShared('rbacManager');
		$manager->setCache($cacheManager->get('cacheMemcached'));
		$userOps = new \Rbac\UserOps($manager, $user->id);

		// Allow access when srbac is in debug mode
		if ($manager->debug() === true) { return true; }

		// Check for rbac access
		if (!$manager->checkAccess($access, $userOps) || $user->isGuest()) {
			return $this->onUnauthorizedAccess($di);
		} else {
			return true;
		}
	}

	/**
	 * Extending controllers can override this to manually specify allowed actions
	 * @return array
	 */
	protected function allowedAccess()
	{
		return array();
	}

	/**
	 *	Check if the unautorizedacces is a result of the user no longer being logged in.
	 *	If so, redirect the user to the login page and after login return the user to the page they tried to open.
	 *	If not, show the unautorizedacces message.
	 */
	protected function onUnauthorizedAccess($di)
	{
		if ($di->getShared('user')->isGuest()) {
			$di->getShared('session')->set('redirect', $di->getShared('request')->getUri());
			$di->getShared('response')->redirect('/account/login');
		} else {
			throw new \Exception('You are not authorized to this action');
		}
	}
}
