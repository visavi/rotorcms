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

include_once (BASEDIR."/bootstrap/counters.php");

include_once (DATADIR.'/advert/bottom_all.dat');

// -------- Удаление флеш сообщения ---------//
if (isset($_SESSION['note'])) {
	unset($_SESSION['note']);
}

if (is_user()) {
	// -------------------------- Дайджест ------------------------------------//
	$visit = Visit::first(array('conditions' => array('user_id = ?', $current_user->id)));
	if (!$visit) {
		$visit = new Visit();
		$visit->user_id = $current_user->id;
		$visit->count = 1;
	} else {
		$visit->count = ($visit->created_at->format('Ymd') == date('Ymd')) ? $visit->count + 1 : 0;
	}

	$visit->ip = $ip;
	$visit->self = $php_self;
	$visit->page = isset($config['newtitle']) ? $config['newtitle'] : '';
	$visit->save();
}
?>

<?php if ($ip != '127.0.0.1'){?>
<!-- Yandex.Metrika counter -->

<!-- /Yandex.Metrika counter -->
<?php } ?>

<?php
include_once (PUBLICDIR.'/themes/'.$config['themes'].'/foot.php');
?>
