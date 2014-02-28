<?

class Enum extends Model
{

	private static $enum = array();
	
	public $Name;

	// FIXED
	public function __construct($str = '')
	{
		$this->Name = $str;
	}

	public static function load($file = null)
	{
		$file = self::file($file);
		$cat = '';
		foreach (file($file) as $line)
		{
			$line = trim($line);
			if (preg_match('/^\[(.+)\]$/', $line, $res))
			{
				$cat = trim($res[1]);
			}
			else if ($line !== '' && $cat)
			{
				if (!isset(self::$enum[$cat]))
				{
					self::$enum[$cat] = array();
				}
				self::$enum[$cat][] = new self($line);
			}
		}
	}

	public static function get($cat)
	{
		return isset(self::$enum[$cat]) ? self::$enum[$cat] : array();
	}

}

Enum::load();