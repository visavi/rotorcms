<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require_once __DIR__.'/../bootstrap/start.php';
require_once __DIR__.'/../bootstrap/functions.php';
require_once __DIR__.'/../bootstrap/header.php';

if (App::router()['target'] && is_callable(App::router()['target'])) {

	call_user_func_array(App::router()['target'], App::router()['params']);

} elseif (App::router()['target']) {

	include_once BASEDIR.'/app/controllers/'.App::router()['target'].'.php';

} else {
	App::view('pages.404');
}

?>
