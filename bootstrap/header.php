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

Registry::set('ip', real_ip());
Registry::set('brow', get_user_agent());

/**
 *  Сжатие и буферизация данныx
 */
if (Setting::get('gzip')) {
	Compressor::start();
}

/**
 * Авторизация по cookies
 */
if (empty($_SESSION['id']) || empty($_SESSION['pass'])) {
	if (!empty($_COOKIE['id']) && !empty($_COOKIE['pass'])) {

		$id = intval($_COOKIE['id']);
		$pass = strval($_COOKIE['pass']);

		if ($user = User::first($id)) {
			if ($pass === md5($user->password.Setting::get('keypass'))) {
				session_regenerate_id(1);

				$_SESSION['ip'] = Registry::get('ip');
				$_SESSION['id'] = $user->id;
				$_SESSION['pass'] = md5(Setting::get('keypass').$user->password);
			}
		}
	}
}

/**
 * Получение данных пользователя
 */
if (!empty($_SESSION['id']) && !empty($_SESSION['pass'])) {

	$user = User::first($_SESSION['id']);

	if ($user && $_SESSION['pass'] == md5(Setting::get('keypass').$user->password)) {
		Registry::set('user', $user);
	} else {
		Registry::set('user', new User);
	}
}

if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = empty($config['session']) ? 0 : generate_password(6);
}

//ob_start('ob_processing');
############################################################################################
##                            Получение данных пользователя                               ##
############################################################################################
if (User::check()) {
	// ---------------------- Получение ежедневного бонуса -----------------------//
	if (!User::get('timebonus') || User::get('timebonus') < new DateTime('-1 day')) {

		$user = User::first(User::get('id'));
		$user->timebonus = new DateTime();
		$user->money = $user->money + Setting::get('bonusmoney');
		$user->save();

		notice('Получен ежедневный бонус '.moneys(Setting::get('bonusmoney')).'!');
	}

	// ------------------ Запись текущей страницы для админов --------------------//
/*	if (strstr($php_self, '/admin')) {

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
	}*/
}
