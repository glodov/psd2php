<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

define('TEMPLATE_DIR', dirname(__DIR__).'/tpl');

include_once(__DIR__.'/file.php');
include_once(__DIR__.'/text.php');

foreach (File::readDir(__DIR__, true) as $file)
{
	$name = basename($file);
	if (preg_match('/\.php$/', $name) && $name != 'app.php')
	{
		include_once($file);
	}
}