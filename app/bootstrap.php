<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container as Container;
use Illuminate\Support\Facades\Facade as Facade;
use Illuminate\Support\Facades\DB;

define('STARTTIME', microtime(1));
define('BASEDIR', dirname(__DIR__));
define('APP', BASEDIR.'/app');
define('HOME', BASEDIR.'/public');
define('STORAGE', APP.'/storage');
define('PCLZIP_TEMPORARY_DIR', STORAGE.'/temp/');

/**
 * Автозагрузка классов
 */
require_once BASEDIR.'/vendor/autoload.php';

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

if (! env('APP_ENV')) Dotenv::load(BASEDIR);

if (env('APP_DEBUG')) {
	$whoops = new Whoops\Run;
	$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
	$whoops->register();
}

/**
 * ActiveRecord initialize
 */
/*ActiveRecord\Config::initialize(function($cfg) {

	$cfg->set_model_directory(APP.'/models');
	$cfg->set_connections(array(
		'development' => 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').'/'.env('DB_DATABASE').';charset=utf8'
	));

	//$cfg->set_cache('memcache://localhost', ['expire' => 60]);

	if (env('APP_DEBUG')) {
		$conf = ['append' => false, 'mode' => '0666', 'lineFormat' => '[%3$s] %4$s [%1$s]'];
		$logger = Log::singleton('file', STORAGE.'/mysql.dat', null, $conf);

		$cfg->set_logger($logger);
		$cfg->set_logging(true);
	}
});*/

/**
* Setup a new app instance container
*
* @var Illuminate\Container\Container
*/
$app = new Container();
$app->singleton('app', 'Illuminate\Container\Container');

/**
* Set $app as FacadeApplication handler
*/
Facade::setFacadeApplication($app);

$app['db'] = $app->share(function() {

	$capsule = new Capsule;

	$capsule->addConnection([
		'driver'    => env('DB_DRIVER'),
		'host'      => env('DB_HOST'),
		'database'  => env('DB_DATABASE'),
		'username'  => env('DB_USERNAME'),
		'password'  => env('DB_PASSWORD'),
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	]);

	return $capsule;
});

// Make the Capsule instance available globally via static methods...
$app['db']->setAsGlobal();
// Setup the Eloquent ORM...
$app['db']->bootEloquent();
