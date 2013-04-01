<?php
namespace Rbac;

interface CollectionInterface
{
	/**
	 * Constructor
	 * @param \Rbac\Manager $manager
	 * @param int $identity
	 * @param array $data
	 */
	public function __construct(Manager $manager, $id = 0, array $data = array());

	/**
	 * Set user identity
	 * @param int $identity
	 * @return CollectionInterface
	 */
	public function setIdentity($identity);

	/**
	 * Get the user identity
	 * @return int
	 */
	public function getIdentity();

	/**
	 * Get collection data array
	 * @return array
	 */
	public function data();

	/**
	 * Check if the access to the context is allowed
	 * @param string $context
	 * @return bool
	 */
	public function isAllowed($context);
}