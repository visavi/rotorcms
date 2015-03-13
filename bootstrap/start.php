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
define('APP', BASEDIR.'/app');
define('PUBLIC', BASEDIR.'/public');
define('STORAGE', BASEDIR.'/storage');
define('VIEW', APP.'/views');
define('CACHE', STORAGE.'/cache');
define('PCLZIP_TEMPORARY_DIR', STORAGE.'/temp/');

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

include_once BASEDIR.'/vendor/autoload.php';

// -------- Автозагрузка классов ---------- //
spl_autoload_register(function ($class) {
	include_once BASEDIR.'/app/classes/'.str_replace('\\', '/', $class).'.php';
});

include_once BASEDIR.'/bootstrap/routes.php';
include_once BASEDIR.'/bootstrap/connect.php';

// ------------ ActiveRecord -------------- //
ActiveRecord\Config::initialize(function($cfg) {

	$cfg->set_model_directory(BASEDIR.'/app/models');
	$cfg->set_connections(array(
		'development' => 'mysql://'.DBUSER.':'.DBPASS.'@'.DBHOST.'/'.DBNAME.';charset=utf8'
	));

	$conf = array('append' => false, 'lineFormat' => '[%3$s] %4$s [%1$s]');
	$logger = Log::singleton('file', STORAGE.'/temp/mysql.dat', null, $conf);

	$cfg->set_logger($logger);
	$cfg->set_logging(DEBUGMODE);
});

ActiveRecord\DateTime::$DEFAULT_FORMAT = 'd.m.y / H:i';

date_default_timezone_set(Setting::get('timezone'));
