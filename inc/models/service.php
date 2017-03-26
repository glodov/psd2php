<?php

class Service extends Model
{

	private static $currentId = 0;

	public $Name;

	// FIXED
	public function __construct($str = '')
	{
		$arr = explode("\n", $str, 2);
		if (count($arr) < 2)
		{
			return false;
		}

		$this->Id = ++self::$currentId;
		$this->Name = trim($arr[0]);
	}

	public function __toString()
	{
		return $this->Name;
	}

}

Service::load();