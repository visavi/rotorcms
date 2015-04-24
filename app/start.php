<?php
define('DEBUGMODE', true);
define('BASEDIR', dirname(__DIR__));
define('APP', BASEDIR.'/app');
define('HOME', BASEDIR.'/public');
define('STORAGE', BASEDIR.'/storage');

if (DEBUGMODE) {
	@error_reporting(E_ALL);
	@ini_set('display_errors', true);
	@ini_set('html_errors', true);
	@ini_set('error_reporting', E_ALL);
} else {
	@error_reporting(E_ALL ^ E_NOTICE);
	@ini_set('display_errors', false);
	@ini_set('html_errors', false);
	@ini_set('error_reporting', E_ALL ^ E_NOTICE);
}

session_start();

include_once BASEDIR.'/vendor/autoload.php';

if (DEBUGMODE) {
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
	$whoops->register();
}

/**
 * Автозагрузка классов
 */
$loader = new \Composer\Autoload\ClassLoader();
$loader->add('', BASEDIR.'/app/classes');
$loader->add('', BASEDIR.'/app/controllers');
$loader->register();

include_once BASEDIR.'/app/routes.php';
include_once BASEDIR.'/app/connect.php';

/**
 * Регистрация классов
 */
$aliases = [
	'Blade'       => 'Philo\Blade\Blade',
	'Carbon'      => 'Carbon\Carbon',
	'SimpleImage' => 'abeautifulsite\SimpleImage',
	'Utf8'        => 'Patchwork\Utf8',
];

AliasLoader::getInstance($aliases)->register();
\Patchwork\Utf8\Bootup::initAll();

/**
 * ActiveRecord initialize
 */
ActiveRecord\Config::initialize(function($cfg) use ($connect) {

	$cfg->set_model_directory(BASEDIR.'/app/models');
	$cfg->set_connections(array(
		'development' => 'mysql://'.$connect['dbuser'].':'.$connect['dbpass'].'@'.$connect['dbhost'].'/'.$connect['dbname'].';charset=utf8'
	));

	$conf = ['append' => false, 'lineFormat' => '[%3$s] %4$s [%1$s]'];
	$logger = Log::singleton('file', STORAGE.'/mysql.dat', null, $conf);

	$cfg->set_logger($logger);
	$cfg->set_logging(DEBUGMODE);

});

if (!isset($_SESSION['token'])) $_SESSION['token'] = str_random(16);
if (!isset($_SESSION['captcha'])) $_SESSION['captcha'] = null;

//ActiveRecord\DateTime::$DEFAULT_FORMAT = 'd.m.y H:i';
date_default_timezone_set('Europe/Moscow');
setlocale(LC_TIME, 'rus','ru_RU.UTF-8','rus_RUS.UTF-8','ru_RU');

/**
 * Авторизация по cookies
 */
if (empty($_SESSION['id']) || empty($_SESSION['pass'])) {
	if (!empty($_COOKIE['id']) && !empty($_COOKIE['pass'])) {

		$id = intval($_COOKIE['id']);
		$pass = strval($_COOKIE['pass']);

		if ($user = User::find_by_id($id)) {
			if ($pass === md5($user->password.Setting::get('keypass'))) {

				$_SESSION['id'] = $user->id;
				$_SESSION['pass'] = md5(Setting::get('keypass').$user->password);
			}
		}
	}
}

/**
 * Получение данных пользователя
 */
if (!empty($_SESSION['id']) && !empty($_SESSION['pass'])) {

	$user = User::find_by_id($_SESSION['id']);

	if ($user && $_SESSION['pass'] == md5(Setting::get('keypass').$user->password)) {
		Registry::set('user', $user);
	} else {
		Registry::set('user', new User);
	}
}
