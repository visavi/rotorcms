<?php
$act = isset($current_router['params']['action']) ? check($current_router['params']['action']) : 'index';
$page = !empty($current_router['params']['page']) ? intval($current_router['params']['page']) : 1;

$list = (isset($_GET['list'])) ? check($_GET['list']) : 'all';
$login = (isset($_REQUEST['login'])) ? check($_REQUEST['login']) : '';

show_title('Список пользователей');

switch ($act):
############################################################################################
##                                    Вывод пользователей                                 ##
############################################################################################
case 'index':

	$total['users'] = User::count();
	$total['admins'] = User::count(array('conditions' => array('level <> ?', 'user')));

	$total['all'] = $total['users'];

	if ($total['all'] > 0 && ($page * $config['userlist']) >= $total) {
		$page = ceil($total / $config['userlist']);
	}

	$offset = intval(($page * $config['userlist']) - $config['userlist']);

	$condition = array();

	if ($list == 'admins') {
		$total['all'] = $total['admins'];
		ActiveRecord\Utils::add_condition($condition, array('level <> ?', 'user'));
	}

	$users = User::all(array(
		'conditions' => $condition,
		'order' => 'point DESC, login ASC',
		'offset' => $offset,
		'limit' => $config['userlist'],
	));

	App::render('pages/userlist', compact('users', 'page', 'total', 'list', 'login'));

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
				$page = ceil($position / $config['userlist']);

				$_SESSION['note'] = 'Позиция в рейтинге: '.$position;
				redirect("/users/page/$page?login=$user->login");
			} else {
				show_error('Пользователь с данным логином не найден!');
			}
		} else {
			show_error('Пользователь с данным логином не зарегистрирован!');
		}
	} else {
		show_error('Ошибка! Вы не ввели логин или ник пользователя');
	}

	App::render('includes/back', array('link' => '/users', 'title' => 'Вернуться'));

break;

default:
	redirect("/users");
endswitch;
