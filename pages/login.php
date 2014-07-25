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
$domain = check_string($config['home']);

show_title('Авторизация');

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
case 'index':

	if (!is_user()) {

		if (isset($_REQUEST['login']) && isset($_REQUEST['password'])) {

			$login = isset($_REQUEST['login']) ? check($_REQUEST['login']) : '';
			$password = isset($_REQUEST['password']) ? md5(md5(trim($_REQUEST['password']))) : '';
			$haunter = isset($_POST['haunter']) ? 1 : 0;

			if (!empty($login) && !empty($password)) {

				$field = strpos($login, '@') ? 'email' : 'login';

				$user = User::first(array('conditions' => array("$field=? and password=?", $login, $password)));
				if ($user) {

					if (empty($haunter)) {
						setcookie('id', $user->id, time() + 3600 * 24 * 365, '/', $domain);
						setcookie('password', md5($password.$config['keypass']), time() + 3600 * 24 * 365, '/', $domain, null, true);
					}

					$_SESSION['id'] = $user->id;
					$_SESSION['password'] = md5($config['keypass'].$password);
					$_SESSION['ip'] = $ip;

					$user->visits = $user->visits + 1;
					$user->timelastlogin = new DateTime();
					$user->save();

					notice('Вы успешно авторизованы!');
					redirect('/index.php');
				}

			}

			notice('Ошибка авторизации. Неправильный логин или пароль!');
			redirect('login.php');
		}

		render('pages/login');
	} else {
		redirect('/index.php');
	}
break;

############################################################################################
##                                       Выход                                            ##
############################################################################################
case 'exit':
	$_SESSION = array();
	setcookie('password', '', time() - 3600, '/', $domain, null, true);
	setcookie(session_name(), '', time() - 3600, '/', '');
	session_destroy();

	redirect('/index.php');
break;

default:
	redirect("login.php");
endswitch;

include_once ('../themes/footer.php');
?>
