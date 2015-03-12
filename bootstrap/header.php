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
if (Setting::get('gzip')) {
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
if (User::check()) {
	// ---------------------- Получение ежедневного бонуса -----------------------//
	if (!User::get('timebonus') || User::get('timebonus')->getTimestamp()  < SITETIME - 82800) {

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
} else {
	Registry::set('user', new User);
}
