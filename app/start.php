<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require __DIR__.'/bootstrap.php';

session_start();

if (!isset($_SESSION['token'])) $_SESSION['token'] = str_random(16);
if (!isset($_SESSION['captcha'])) $_SESSION['captcha'] = null;

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
		Registry::set('user', new User());
	}
}
