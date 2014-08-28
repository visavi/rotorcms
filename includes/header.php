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
$php_self = (isset($_SERVER['PHP_SELF'])) ? check($_SERVER['PHP_SELF']) : '';
$request_uri = (isset($_SERVER['REQUEST_URI'])) ? check(urldecode($_SERVER['REQUEST_URI'])) : '/index.php';
$http_referer = (isset($_SERVER['HTTP_REFERER'])) ? check(urldecode($_SERVER['HTTP_REFERER'])) : 'Не определено';
$brow = (empty($_SESSION['browser'])) ? $_SESSION['browser'] = get_user_agent() : $_SESSION['browser'];
############################################################################################
##                                 Проверка на ip-бан                                     ##
############################################################################################
if (file_exists(DATADIR.'/temp/ipban.dat')) {
	$arrbanip = unserialize(file_get_contents(DATADIR.'/temp/ipban.dat'));
} else {
	$arrbanip = save_ipban();
}

if (is_array($arrbanip) && count($arrbanip) > 0) {
	foreach($arrbanip as $ipdata) {
		$ipmatch = 0;
		$ipsplit = explode('.', $ip);
		$dbsplit = explode('.', $ipdata);

		for($i = 0; $i < 4; $i++) {
			if ($ipsplit[$i] == $dbsplit[$i] || $dbsplit[$i] == '*') {
				$ipmatch += 1;
			}
		}

		if ($ipmatch == 4) {
			redirect('/pages/banip.php');
		} //бан по IP
	}
}

############################################################################################
##                            Сжатие и буферизация данныx                                 ##
############################################################################################
if (!empty($config['gzip'])) {
	Compressor::start();
}

############################################################################################
##                               Авторизация по cookies                                   ##
############################################################################################
if (empty($_SESSION['id']) && empty($_SESSION['password'])) {
	if (!empty($_COOKIE['id']) && !empty($_COOKIE['password'])) {

		$id = intval($_COOKIE['id']);
		$password = check($_COOKIE['password']);

		$user = User::first($id);

		if ($user) {
			if ($password == md5($user->password.$config['keypass'])) {
				session_regenerate_id(1);

				$_SESSION['id'] = $user->id;
				$_SESSION['password'] = md5($config['keypass'].$user->password);
				$_SESSION['ip'] = $ip;

				$user->visits = $user->visits + 1;
				$user->timelastlogin = new DateTime();
				$user->save();
			}
		}
	}
}

if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = empty($config['session']) ? 0 : generate_password(6);
}

ob_start('mc');
ob_start('ob_processing');
############################################################################################
##                            Получение данных пользователя                               ##
############################################################################################
if ($user = is_user()) {
	$log  = $user->id; // Временно
	// ---------------------- Переопределение глобальных настроек -------------------------//
	$config['themes']     = $user->themes;      # Скин/тема по умолчанию
	$config['bookpost']   = $user->postguest;   # Вывод сообщений в гостевой
	$config['postnews']   = $user->postnews;    # Новостей на страницу
	$config['forumpost']  = $user->postforum;   # Вывод сообщений в форуме
	$config['forumtem']   = $user->themesforum; # Вывод тем в форуме
	$config['privatpost'] = $user->postprivat;  # Вывод писем в привате
	$config['navigation'] = $user->navigation;  # Быстрый переход

	if ($user->ban) {
		if (!strsearch($php_self, array('/pages/ban.php', '/pages/rules.php'))) {
			redirect('/pages/ban.php?log='.$log);
		}
	}

	if ($config['regkeys'] > 0 && $user->confirmreg > 0 && empty($user->ban)) {
		if (!strsearch($php_self, array('/pages/key.php', '/pages/login.php'))) {
			redirect('/pages/key.php?log='.$log);
		}
	}

	// --------------------- Проверка соответствия ip-адреса ---------------------//
	if (!empty($user->ipbinding)) {
		if ($_SESSION['ip'] != $ip) {
			$_SESSION = array();
			setcookie(session_name(), '', 0, '/', '');
			session_destroy();
			redirect(html_entity_decode($request_uri));
		}
	}

	// ---------------------- Получение ежедневного бонуса -----------------------//
	if (!$user->timebonus || $user->timebonus->getTimestamp()  < SITETIME - 82800) {

		$user->timebonus = new DateTime();
		$user->money = $user->money + $config['bonusmoney'];
		$user->save();

		notice('Получен ежедневный бонус '.moneys($config['bonusmoney']).'!');
	}

	// ------------------ Запись текущей страницы для админов --------------------//
	if (strstr($php_self, '/admin')) {

		$attributes = array(
			'user_id' => $user->id,
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
}
