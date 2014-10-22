<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
$debugmode = 1;

if ($debugmode) {
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

define('STARTTIME', microtime(1));
define('BASEDIR', dirname(__DIR__));
define('DATADIR', BASEDIR.'/local');
define('SITETIME', time());
define('PCLZIP_TEMPORARY_DIR', BASEDIR.'/local/temp/');

//@ini_set('session.save_path', dirname(BASEDIR).'/tmp');
session_name('SID');
session_start();

include_once (BASEDIR.'/includes/connect.php');

// -------- Автозагрузка классов ---------- //
spl_autoload_register(function ($class) {
	include_once BASEDIR.'/includes/classes/'.$class.'.php';
});

// ------------ ActiveRecord -------------- //
include_once (BASEDIR.'/includes/classes/ActiveRecord.php');
ActiveRecord\Config::initialize(function($cfg) {

	$cfg->set_model_directory(BASEDIR.'/models');
	$cfg->set_connections(array(
		'development' => 'mysql://'.DBUSER.':'.DBPASS.'@'.DBHOST.'/'.DBNAME.';charset=utf8'
	));
});

ActiveRecord\Errors::$DEFAULT_ERROR_MESSAGES = array(
	'inclusion'    => "не включено в список",
	'exclusion'    => "зарезервировано",
	'invalid'      => "недействительно",
	'confirmation' => "не совпадает с подтверждением",
	'accepted'     => "должно быть принято",
	'empty'        => "не может быть пустым",
	'blank'        => "не может быть пустым",
	'too_long'     => "слишком длинное (максимум %d симв.)",
	'too_short'    => "слишком короткое (минимум %d симв.)",
	'wrong_length' => "имеет неправильную длину (должно быть %d симв.)",
	'taken'        => "уже принято",
	'not_a_number' => "не является числом",
	'greater_than' => "должно быть больше чем %d",
	'equal_to'     => "должно быть идентично %d",
	'less_than'    => "должно быть меньше чем %d",
	'odd'          => "должно быть нечетным",
	'even'         => "должно быть четным",
	'unique'       => "должно быть уникальным",
	'less_than_or_equal_to' => "должно быть меньше или равно %d",
	'greater_than_or_equal_to' => "должно быть больше или равно %d"
);

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

?>
