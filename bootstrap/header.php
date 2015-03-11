<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
if (!defined('BASEDIR')) {
	exit(header('Location: /index.php'));
}

$ip = real_ip();
$brow = (empty($_SESSION['browser'])) ? $_SESSION['browser'] = get_user_agent() : $_SESSION['browser'];

/**
 *  Сжатие и буферизация данныx
 */
if (!empty($config['gzip'])) {
	Compressor::start();
}

/**
 * Авторизация по cookies
 */
if (empty($_SESSION['id']) && empty($_SESSION['password'])) {
	if (!empty($_COOKIE['id']) && !empty($_COOKIE['password'])) {

		$id = intval($_COOKIE['id']);
		$password = check($_COOKIE['password']);

		$user = User::first($id);

		if ($user) {
			if ($password == md5($user->password.$config['keypass'])) {
				session_regenerate_id(1);

				$_SESSION['ip'] = $ip;
				$_SESSION['id'] = $user->id;
				$_SESSION['password'] = md5($config['keypass'].$user->password);
			}
		}
	}
}

if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = empty($config['session']) ? 0 : generate_password(6);
}

ob_start('ob_processing');
############################################################################################
##                            Получение данных пользователя                               ##
############################################################################################
$user = Registry::set('user', is_user());

if ($user) {

	$config['themes'] = $current_user->themes; # Скин/тема по умолчанию

	if ($current_user->ban) {
		if (!strsearch($php_self, array('/pages/ban.php', '/pages/rules.php'))) {
			redirect('/pages/ban.php?user='.$current_user->id);
		}
	}

	if ($config['regkeys'] > 0 && $current_user->confirmreg > 0 && empty($current_user->ban)) {
		if (!strsearch($php_self, array('/pages/key.php', '/pages/login.php'))) {
			redirect('/pages/key.php?user='.$current_user->id);
		}
	}

	// --------------------- Проверка соответствия ip-адреса ---------------------//
	if (!empty($current_user->ipbinding)) {
		if ($_SESSION['ip'] != $ip) {
			$_SESSION = array();
			setcookie(session_name(), '', 0, '/', '');
			session_destroy();
			redirect(html_entity_decode($request_uri));
		}
	}

	// ---------------------- Получение ежедневного бонуса -----------------------//
	if (!$current_user->timebonus || $current_user->timebonus->getTimestamp()  < SITETIME - 82800) {

		$current_user->timebonus = new DateTime();
		$current_user->money = $current_user->money + $config['bonusmoney'];
		$current_user->save();

		notice('Получен ежедневный бонус '.moneys($config['bonusmoney']).'!');
	}

	// ------------------ Запись текущей страницы для админов --------------------//
	if (strstr($php_self, '/admin')) {

		$attributes = array(
			'user_id' => $current_user->id,
			'request' => $request_uri,
			'referer' => $http_referer,
			'ip' => $ip,
			'brow' => $brow,
		);

		Log::create($attributes);

		$logs = Log::all(array('offset' => 500, 'limit' => 10, 'order' => 'updated_at desc'));
		if ($logs){
			$delete = ActiveRecord\collect($logs, 'id');
			Log::table()->delete(array('id' => $delete));
		}
	}
} else {
	$current_user = new User;
}
