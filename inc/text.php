<?php

final class Text
{

	public static function getBlocks($text, $object)
	{
		$result = array();
		$name = is_object($object) ? get_class($object) : $object;
		$str = '';
		if (!is_array($text))
		{
			$text = explode("\n", $text);
		}
		foreach ($text as $line)
		{
			if (trim($line) == '-')
			{
				$result[] = new $name($str);
				$str = '';
			}
			else
			{
				$str .= $line."\n";
			}
		}
		if ($str)
		{
			$result[] = new $name($str);
		}
		return $result;
	}

	public static function encode($text)
	{
		$text = preg_replace('/\s/', '-', $text);

		// Finnish characters
		return str_replace(self::mb_str_split("äåö"), self::mb_str_split("aao"), $text);
	}

	private static function mb_str_split($text)
	{
	    return preg_split('~~u', $text, null, PREG_SPLIT_NO_EMPTY);;
	}

}
