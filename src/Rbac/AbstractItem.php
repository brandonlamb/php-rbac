<?php
namespace Rbac;

abstract class AbstractItem
{
	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $description;

	/**
	 * Constructor
	 * @param int $id
	 * @param string $name
	 * @param string $description
	 */
	public function __construct($id = 0, $name = null, $description = null)
	{
		$this->id($id);
		$this->name($name);
		$this->description($description);
	}

	/**
	 * Get/set operation id
	 * @param int $id
	 * @return int
	 */
	public function id($id = null)
	{
		null !== $id && $this->id = (int) $id;
		return (int) $this->id;
	}

	/**
	 * Get/set operation name
	 * @param string $name
	 * @return string
	 */
	public function name($name = null)
	{
		null !== $name && $this->name = strtolower($name);
		return (string) $this->name;
	}

	/**
	 * Get/set operation description
	 * @param string $description
	 * @return string
	 */
	public function description($description = null)
	{
		null !== $description && $this->description = (string) $description;
		return (string) $this->description;
	}
}