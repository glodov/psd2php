<?php

final class URL
{

	public static function get($object)
	{
		$url = '#';
		if ($object instanceof Model)
		{
			if (method_exists($object, 'getUrl'))
			{
				$url = $object->getUrl();
			}
			else
			{
				$url = strtolower(get_class($object)).'.html';
				if (property_exists($object, 'Id'))
				{
					$url .= '?id='.$object->Id;
				}
			}
		}
		else if (is_string($object))
		{
			$url = $object;
		}
		return $url;
	}
	
	public static function on($url)
	{
		$self = isset($_SERVER['SCRIPT_NAME']) ? trim($_SERVER['SCRIPT_NAME'], '/') : 'index.php';
		$self = basename($self);
		$self = strtolower(preg_replace('/\.php$/', '', $self));
		$url = strtolower(preg_replace('/\.(html|php)$/', '', $url));
		if (substr($self, 0, strlen($url)) === $url || substr($url, 0, strlen($self)) === $self)
		{
			return true;
		}
		return false;
	}

}