<?

function usage(){
	echo "Script usage: php SOURCE [TARGET]
	- SOURCE is source folder 
	- TARGET is destination folder, by default SOURCE.pro
	";
	exit;
}

if (empty($argv[1]))
{
	usage();
}
$source = $argv[1];
$target = empty($argv[2]) ? ($source.'.pro') : $argv[2];

if (!is_dir($source))
{
	echo "Source folder $source does not exist\n";
	exit;
}

$allowed = array('css', 'js', 'images', 'img');
if (!is_dir($target))
{
	mkdir($target);
}

if (substr($source, 0, 1) !== '/')
{
	$source = __DIR__.'/'.$source;
}
if (substr($target, 0, 1) !== '/')
{
	$target = __DIR__.'/'.$target;
}

$files = scandir($source);
chdir($source);
foreach ($files as $i => $file)
{
	$name = basename($file);
	$from = $source.'/'.$name;
	$to = $target.'/'.$name;
	if (in_array($name, $allowed))
	{
		$cmd = 'cp -Rf "'.$from.'" "'.$target.'"';
		exec($cmd);
		echo "$to - ".(is_dir($to) ? 'OK' : 'false')."\n";
	}
	else if (preg_match('/\.php$/', $name))
	{
		ob_start();
		include($file);
		$data = ob_get_contents();
		ob_end_clean();
		$to = preg_replace('/php$/', 'html', $to);
		$size = file_put_contents($to, $data);
		echo "$to - {$size}b\n";
	}
}

echo "DONE\n";