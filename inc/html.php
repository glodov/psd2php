<?

final class HTML
{

	public static function insert($file, array $data = array())
	{
		$file = TEMPLATE_DIR.'/'.$file;
		ob_start();
		extract($data);
		include($file);
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}

	public static function dev()
	{
		if (isset($_SERVER['argv']) && count($_SERVER['argv']) > 0)
		{
			return false;
		}
		return count($_SERVER) > 0;
	}

	public static function checked($bool)
	{
		return $bool ? 'checked="checked"' : '';
	}

}