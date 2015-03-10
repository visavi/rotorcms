<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
define('DEBUGMODE', true);
define('STARTTIME', microtime(1));
define('BASEDIR', dirname(__DIR__));
define('DATADIR', BASEDIR.'/local');
define('SITETIME', time()); //Todo удалить
define('PCLZIP_TEMPORARY_DIR', BASEDIR.'/local/temp/');

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

//@ini_set('session.save_path', dirname(BASEDIR).'/tmp');
session_name('SID');
session_start();

include_once BASEDIR.'/bootstrap/connect.php';
include_once BASEDIR.'/vendor/autoload.php';

//use Philo\Blade\Blade;

//$views = BASEDIR.'/views';
//$cache = BASEDIR.'/cache';

//$blade = new Blade($views, $cache);
//echo $blade->view()->make('hello', compact('router'));


// -------- Автозагрузка классов ---------- //
spl_autoload_register(function ($class) {
	include_once BASEDIR.'/app/classes/'.str_replace('\\', '/', $class).'.php';
});

// ------------ ActiveRecord -------------- //
ActiveRecord\Config::initialize(function($cfg) {

	$cfg->set_model_directory(BASEDIR.'/app/models');
	$cfg->set_connections(array(
		'development' => 'mysql://'.DBUSER.':'.DBPASS.'@'.DBHOST.'/'.DBNAME.';charset=utf8'
	));

	$conf = array('error_prepend' => '<pre class="prettyprint linenums">',
				  'error_append'  => '</pre>');

	//$logger = Log::singleton('file', DATADIR.'/temp/mysql.dat');
	//$logger = Log::singleton('display', '', '', $conf);

	//$cfg->set_logger($logger);
	//$cfg->set_logging(DEBUGMODE);

	//$cfg->set_cache("memcache://localhost", array("expire" => 60));
	//$cfg->set_date_format("Y-m-d H:i:s");
});

ActiveRecord\DateTime::$DEFAULT_FORMAT = 'd.m.y / H:i';

if (!file_exists(DATADIR.'/temp/setting.dat')) {
	$settings = Setting::all();

	$config = array();
	foreach($settings as $setting) {
		$config[$setting->name] = $setting->value;
	}
	file_put_contents(DATADIR.'/temp/setting.dat', serialize($config), LOCK_EX);
}

$config = unserialize(file_get_contents(DATADIR.'/temp/setting.dat'));

date_default_timezone_set($config['timezone']);
