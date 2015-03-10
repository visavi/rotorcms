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
include_once __DIR__.'/../bootstrap/routes.php';
include_once __DIR__.'/themes/header.php';

var_dump($current_router);
if ($current_router && is_array($current_router['target'])) {

	while (ob_get_level()) {
		ob_end_clean();
	}
	die(include_once BASEDIR.'/app/controllers/'.$current_router['target']['page']);

} elseif ($current_router && is_callable($current_router['target']) ) {

	call_user_func_array($current_router['target'], $current_router['params'] );

} elseif ($current_router) {

	include_once BASEDIR.'/app/controllers/'.$current_router['target'];

} else {

	include_once BASEDIR.'/app/controllers/pages/404.php';
}

include_once 'themes/footer.php';
?>
