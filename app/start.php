<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
define('STARTTIME', microtime(1));
define('BASEDIR', dirname(__DIR__));
define('APP', BASEDIR.'/app');
define('HOME', BASEDIR.'/public');
define('STORAGE', APP.'/storage');
define('PCLZIP_TEMPORARY_DIR', STORAGE.'/temp/');

session_start();

/**
 * Автозагрузка классов
 */
include_once BASEDIR.'/vendor/autoload.php';

$loader = new Composer\Autoload\ClassLoader();
$loader->add('', APP.'/classes');
$loader->add('', APP.'/controllers');
$loader->register();

include_once APP.'/routes.php';
include_once APP.'/helpers.php';

Dotenv::load(BASEDIR, '.env.example');
Patchwork\Utf8\Bootup::initAll();

if (env('APP_DEBUG')) {
	$whoops = new Whoops\Run;
	$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
	$whoops->register();
}

/**
 * Регистрация классов
 */
$aliases = [
	'Blade'       => 'Philo\Blade\Blade',
	'Carbon'      => 'Carbon\Carbon',
	'SimpleImage' => 'abeautifulsite\SimpleImage',
	'Utf8'        => 'Patchwork\Utf8',
	'Curl'        => 'Curl\Curl',
];

AliasLoader::getInstance($aliases)->register();

/**
 * ActiveRecord initialize
 */
ActiveRecord\Config::initialize(function($cfg) {

	$cfg->set_model_directory(APP.'/models');
	$cfg->set_connections(array(
		'development' => 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').'/'.env('DB_DATABASE').';charset=utf8'
	));

	if (env('APP_DEBUG')) {
		$conf = ['append' => false, 'lineFormat' => '[%3$s] %4$s [%1$s]'];
		$logger = Log::singleton('file', STORAGE.'/mysql.dat', null, $conf);

		$cfg->set_logger($logger);
		$cfg->set_logging(true);
	}
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
			if ($pass === md5($user->password.env('APP_KEY'))) {

				$_SESSION['id'] = $user->id;
				$_SESSION['pass'] = md5(env('APP_KEY').$user->password);
			}
		}
	}
}

/**
 * Получение данных пользователя
 */
if (!empty($_SESSION['id']) && !empty($_SESSION['pass'])) {

	$user = User::find_by_id($_SESSION['id']);

	if ($user && $_SESSION['pass'] == md5(env('APP_KEY').$user->password)) {
		Registry::set('user', $user);
	} else {
		Registry::set('user', new User);
	}
}
