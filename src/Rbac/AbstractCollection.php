<?php
namespace Rbac;

abstract class AbstractCollection
{
	/** @var int */
	protected $identity;

	/** @var array */
	protected $data;

	/**
	 * @{inherit}
	 */
	public function __construct(Manager $manager, $id = 0, array $data = array())
	{
		$this->manager = $manager;
		$this->setIdentity($id);
		!empty($data) && $this->data = $this->parse($data);
	}

	/**
	 * @{inherit}
	 */
	public function setIdentity($identity)
	{
		$this->identity = (int) $identity;
		return $this;
	}

	/**
	 * @{inherit}
	 */
	public function getIdentity()
	{
		return (int) $this->identity;
	}

	/**
	 * @{inherit}
	 */
	public function data()
	{
		return $this->data;
	}

	/**
	 * @{inherit}
	 */
	public function isAllowed($access)
	{
		null === $this->data && $this->data = $this->getData();
		return isset($this->data[$access]);
	}

	/**
	 * Loop through data rows and create array of item objects
	 * @param string $itemClass
	 * @param array $rows
	 * @return array
	 */
	protected function parse($itemClass, array $rows = array())
	{
		$data = array();
		foreach ($rows as $row) {
			$item = new $itemClass($row['item_id'], $row['item_name'], $row['item_desc']);
			$data[$item->name()] = $op;
		}

		return $data;
	}
}
