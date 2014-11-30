<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require_once ('../includes/start.php');
require_once ('../includes/functions.php');
require_once ('../includes/header.php');
include_once ('../themes/header.php');

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;
$uz = (isset($_GET['uz'])) ? check($_GET['uz']) : (isset($_POST['uz'])) ? check($_POST['uz']) : '';

show_title('Список пользователей');

switch ($act):
############################################################################################
##                                    Вывод пользователей                                 ##
############################################################################################
case 'index':

	$total = User::count();
	//$total = DB::run() -> querySingle("SELECT count(*) FROM `users`;");

	$total = ($start < $total) ? $start : 0;

	$users = User::all(array('order' => 'point DESC, login ASC', 'offset' => $start, 'limit' => $config['userlist']));

	//$queryusers = DB::run() -> query("SELECT * FROM `users` ORDER BY `users_point` DESC, `users_login` ASC LIMIT ".$start.", ".$config['userlist'].";");

	render('pages/userlist', compact('users', 'start', 'total'));

break;

############################################################################################
##                                  Поиск пользователя                                    ##
############################################################################################
case 'search':

	if (!empty($uz)) {
		$queryuser = DB::run() -> querySingle("SELECT `users_login` FROM `users` WHERE LOWER(`users_login`)=? OR LOWER(`users_nickname`)=? LIMIT 1;", array(strtolower($uz), utf_lower($uz)));

		if (!empty($queryuser)) {
			$queryrating = DB::run() -> query("SELECT `users_login` FROM `users` ORDER BY `users_point` DESC, `users_login` ASC;");
			$ratusers = $queryrating -> fetchAll(PDO::FETCH_COLUMN);

			foreach ($ratusers as $key => $ratval) {
				if ($queryuser == $ratval) {
					$rat = $key + 1;
				}
			}

			if (!empty($rat)) {
				$page = floor(($rat - 1) / $config['userlist']) * $config['userlist'];

				$_SESSION['note'] = 'Позиция в рейтинге: '.$rat;
				redirect("userlist.php?start=$page&uz=$queryuser");
			} else {
				show_error('Пользователь с данным логином не найден!');
			}
		} else {
			show_error('Пользователь с данным логином не зарегистрирован!');
		}
	} else {
		show_error('Ошибка! Вы не ввели логин или ник пользователя');
	}

	render('includes/back', array('link' => 'userlist.php?start='.$start, 'title' => 'Вернуться'));

break;

default:
	redirect("userlist.php");
endswitch;

include_once ('../themes/footer.php');
?>
