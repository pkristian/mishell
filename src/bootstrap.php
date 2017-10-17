<?php

require "vendor/autoload.php";


function __autoload($class_name)
{
	$filename = str_replace('\\', '/', $class_name) . '.php';

	if (!file_exists($filename))
	{
		return false;
	}
	require_once $filename;

	return true;
}

spl_autoload_register("__autoload");

$app = new \App\Main($argv);
$app->run();
