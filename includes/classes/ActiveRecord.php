<?php
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('PHP ActiveRecord requires PHP 5.3 or higher');

define('PHP_ACTIVERECORD_VERSION_ID','1.0');

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_PREPEND'))
	define('PHP_ACTIVERECORD_AUTOLOAD_PREPEND',true);

require __DIR__.'/ActiveRecord/Singleton.php';
require __DIR__.'/ActiveRecord/Config.php';
require __DIR__.'/ActiveRecord/Utils.php';
require __DIR__.'/ActiveRecord/DateTime.php';
require __DIR__.'/ActiveRecord/Model.php';
require __DIR__.'/ActiveRecord/Table.php';
require __DIR__.'/ActiveRecord/ConnectionManager.php';
require __DIR__.'/ActiveRecord/Connection.php';
require __DIR__.'/ActiveRecord/Serialization.php';
require __DIR__.'/ActiveRecord/SQLBuilder.php';
require __DIR__.'/ActiveRecord/Reflections.php';
require __DIR__.'/ActiveRecord/Inflector.php';
require __DIR__.'/ActiveRecord/CallBack.php';
require __DIR__.'/ActiveRecord/Exceptions.php';
require __DIR__.'/ActiveRecord/Cache.php';

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_DISABLE'))
	spl_autoload_register('activerecord_autoload',false,PHP_ACTIVERECORD_AUTOLOAD_PREPEND);

function activerecord_autoload($class_name)
{
	$path = ActiveRecord\Config::instance()->get_model_directory();
	$root = realpath(isset($path) ? $path : '.');

	if (($namespaces = ActiveRecord\get_namespaces($class_name)))
	{
		$class_name = array_pop($namespaces);
		$directories = array();

		foreach ($namespaces as $directory)
			$directories[] = $directory;

		$root .= DIRECTORY_SEPARATOR . implode($directories, DIRECTORY_SEPARATOR);
	}

	$file = "$root/$class_name.php";

	if (file_exists($file))
		require_once $file;
}
