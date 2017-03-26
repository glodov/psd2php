<?php

class Model
{
	
	private static $data = array();

	public function getImage()
	{
		return 'no-image';
	}

	public static function load($file = null)
	{
		$name = get_called_class();
		$file = self::file($file);
		self::$data[$name] = Text::getBlocks(self::trim(file($file)), $name);
	}

	public static function getList(array $params = array())
	{
		$name = get_called_class();
		$result = array();
		$arr = isset(self::$data[$name]) ? self::$data[$name] : array();
		if (count($params) == 0)
		{
			return $arr;
		}
		foreach ($arr as $Item)
		{
			if (self::equal($Item, $params))
			{
				$result[] = $Item;
			}
		}
		return $result;
	}

	public static function getColumns($count = 2)
	{
		$result = array();
		$arr = self::getList();
		$step = ceil(count($arr) / $count);
		for ($i = 0; $i < $count; $i++)
		{
			$result[] = array_slice($arr, $i * $step, $step);
		}
		return $result;
	}

	public static function getItem(array $params)
	{
		foreach (self::getList() as $Item)
		{
			if (self::equal($Item, $params))
			{
				return $Item;
			}
		}
		return new self();
	}

	protected static function file($file = null)
	{
		if ($file === null)
		{
			$file = __DIR__.'/models/'.strtolower(get_called_class()).'.txt';
		}
		return $file;
	}

	private static function equal(Model $Item, array $params)
	{
		$equal = true;
		foreach ($params as $key => $value)
		{
			if (property_exists($Item, $key) && $Item->$key != $value)
			{
				$equal = false;
				break;
			}
		}
		return $equal;
	}

	private static function trim($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $value)
			{
				$data[$key] = self::trim($value);
			}
			return $data;
		}
		else
		{
			return trim($data);
		}
	}

}