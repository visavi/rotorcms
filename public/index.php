<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
include_once __DIR__.'/../app/start.php';

$params = App::router('params');

if (App::router('target') && is_callable(App::router('target'))) {

	call_user_func_array(App::router('target'), $params);

} elseif (App::router('target')) {

	$target = explode('@', App::router('target'));
	$action = isset($target[1]) ? $target[1] : $params['action'];

	call_user_func_array([new $target[0], $action], $params);

} else {
	App::abort(404);
}

if (isset($_SESSION['input'])) unset($_SESSION['input']);
