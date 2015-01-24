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
$login = (isset($_REQUEST['login'])) ? check($_REQUEST['login']) : '';

show_title('Список пользователей');

switch ($act):
############################################################################################
##                                    Вывод пользователей                                 ##
############################################################################################
case 'index':

	$total = User::count();

	$start = ($start < $total) ? $start : 0;

	$users = User::all(array('order' => 'point DESC, login ASC', 'offset' => $start, 'limit' => $config['userlist']));

	render('pages/userlist', compact('users', 'start', 'total', 'login'));

break;

############################################################################################
##                                  Поиск пользователя                                    ##
############################################################################################
case 'search':

	if (!empty($login)) {
		$user = User::first(array('conditions' => array('LOWER(login) = ?', utf_lower($login))));

		if ($user) {
			$users = User::all(array('select' => 'login', 'order' => 'point DESC, login ASC'));
			foreach ($users as $key => $val) {
				if ($user->login == $val->login) {
					$position = $key + 1;
				}
			}

			if (isset($position)) {
				$page = floor(($position - 1) / $config['userlist']) * $config['userlist'];

				$_SESSION['note'] = 'Позиция в рейтинге: '.$position;
				redirect("userlist.php?start=$page&login=$user->login");
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
