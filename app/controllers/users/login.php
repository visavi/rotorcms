<?php
$act = App::router('name') ?: 'login';

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case 'login':

	if (!User::check()) {
		if (isset($_POST['login']) && isset($_POST['password'])) {

			$login = isset($_POST['login']) ? check($_POST['login']) : '';
			$password = isset($_POST['password']) ? trim($_POST['password']) : '';
			$haunter = isset($_POST['haunter']) ? 1 : 0;

			if (!empty($login) && !empty($password)) {

				$field = strpos($login, '@') ? 'email' : 'login';

				$user = User::first(array('conditions' => array("$field=?", $login)));
				if ($user && password_verify($password, $user->password)) {

					if (empty($haunter)) {
						setcookie('id', $user->id, time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST'], null, true);
						setcookie('pass', md5($user->password.env('APP_KEY')), time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST'], null, true);
					}

					$_SESSION['ip'] = Registry::get('ip');
					$_SESSION['id'] = $user->id;
					$_SESSION['pass'] = md5(env('APP_KEY').$user->password);

					if (!empty($_SESSION['social'])) {
						$social = new Social();
						$social->user_id = $user->id;
						$social->network = $_SESSION['social']['network'];
						$social->uid = $_SESSION['social']['uid'];
						$social->save();
					}

					notice('Вы успешно авторизованы!');
					redirect('/');
				}
			}

			notice('Ошибка авторизации. Неправильный логин или пароль!');
			redirect('/login');
		}

		if (isset($_POST['token'])) {
			User::socialLogin($_POST['token']);
		}

		App::view('users/login');
	} else {
		redirect('/');
	}
break;

############################################################################################
##                                       Выход                                            ##
############################################################################################
case 'logout':
	$_SESSION = array();
	setcookie('pass', '', time() - 3600, '/', $_SERVER['HTTP_HOST'], null, true);
	setcookie(session_name(), '', time() - 3600, '/', '');
	session_destroy();

	redirect('/');
break;

default:
	redirect('/login');
endswitch;

