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

show_title('Регистрация');

if ($config['openreg'] == 1) {
	if (!is_user()) {
		if (empty($_SESSION['reguser'])) {
			switch ($act):
			############################################################################################
			##                                    Главная страница                                    ##
			############################################################################################
				case 'index':

					if (isset($_POST['token'])) {
						User::socialLogin($_POST['token']);
					}

					render('pages/registration');
				break;

				############################################################################################
				##                                       Регистрация                                      ##
				############################################################################################
				case 'register':

					$login = check($_POST['login']);
					$password = check($_POST['password']);
					$email = (!empty($config['regmail'])) ? strtolower(check($_POST['email'])) : '';
					$gender = ($_POST['gender'] == 1) ? 1 : 2;
					$invite = (!empty($config['invite'])) ? check($_POST['invite']) : '';
					$captcha = check(strtolower($_POST['captcha']));
					$domain = (!empty($config['regmail'])) ? utf_substr(strrchr($email, '@'), 1) : '';
					$registration_key = '';

					$validation = new Validation;

					$validation -> addRule('equal', array($captcha, $_SESSION['protect']), 'Проверочное число не совпало с данными на картинке!')
						-> addRule('regex', array($login, '|^[a-z0-9\-]+$|i'), 'Недопустимые символы в логине. Разрешены знаки латинского алфавита, цифры и дефис!', true)
						-> addRule('regex', array($password, '|^[а-яa-z0-9_\-\.]+$|iu'), 'Недопустимые символы в пароле. Разрешены знаки алфавита, цифры, дефис, подчеркивание и точка!', true)
						-> addRule('email', $email, 'Вы ввели неверный адрес e-mail, необходим формат name@site.domen!', $config['regmail'])
						-> addRule('string', $invite, 'Слишком длинный или короткий пригласительный ключ!', $config['invite'], 10, 20)
						-> addRule('string', $login, 'Слишком длинный или короткий логин!', true, 3, 20)
						-> addRule('string', $password, 'Слишком длинный или короткий пароль!',  true, 6, 30)
						-> addRule('not_equal', array($login, $password), 'Пароль и логин должны отличаться друг от друга!');


					if (substr_count($login, '-') > 2) {
						$validation -> addError('Запрещено использовать в логине слишком много дефисов!');
					}

					if (!empty($login)){
						// Проверка логина на существование
						$reglogin = User::first(array('conditions' => array("login = ?", $login)));
						$validation -> addRule('empty', $reglogin, 'Пользователь с данным логином уже зарегистрирован!');

						// Проверка логина в черном списке
						$blacklogin = Blacklist::first(array('conditions' => array("type = ? AND value = ?", 2, $login)));
						$validation -> addRule('empty', $blacklogin, 'Выбранный вами логин занесен в черный список!');
					}

					if (!empty($config['regmail']) && !empty($email)){
						// Проверка email на существование
						$regmail = User::first(array('conditions' => array("email = ?", $email)));
						$validation -> addRule('empty', $regmail, 'Указанный вами адрес e-mail уже используется в системе!');

						// Проверка email в черном списке
						$blackmail = Blacklist::first(array('conditions' => array("type = ? AND value = ?", 1, $email)));
						$validation -> addRule('empty', $blackmail, 'Указанный вами адрес email занесен в черный список!');

						// Проверка домена от email в черном списке
						$blackdomain = Blacklist::first(array('conditions' => array("type = ? AND value = ?", 3, $domain)));
						$validation -> addRule('empty', $blackdomain, 'Домен от вашего адреса email занесен в черный список!');
					}
					// Проверка пригласительного ключа
					if (!empty($config['invite'])){
						$invitation = Invite::first(array('conditions' => array("invite = ? AND used = ?", $invite, 0)));
						$validation -> addRule('not_empty', $invitation, 'Ключ приглашения недействителен!');
					}

					// Регистрация аккаунта
					if ($validation->run(3)){

						if ($config['regkeys'] == 1 && empty($config['regmail'])) {
							$config['regkeys'] = 0;
						}

						// ------------------------- Уведомление о регистрации на E-mail --------------------------//
						$regmessage = "Добро пожаловать, ".$login." \nТеперь вы зарегистрированный пользователь сайта ".$config['home']." , сохраните ваш пароль и логин в надежном месте, они вам еще пригодятся. \nВаши данные для входа на сайт \nЛогин: ".$login." \nПароль: ".$password." \n\nНадеемся вам понравится у нас! \nС уважением администрация сайта \nЕсли это письмо попало к вам по ошибке, то просто проигнорируйте его \n\n";

						if ($config['regkeys'] == 1) {
							$registration_key = generate_password();

							echo '<b><span style="color:#ff0000">Внимание! После входа на сайт, вам будет необходимо ввести мастер-ключ для подтверждения регистрации<br />';
							echo 'Мастер-ключ был выслан вам на почтовый ящик: '.$email.'</span></b><br /><br />';

							$regmessage .= "Внимание! \nДля подтверждения регистрации необходимо в течении 24 часов ввести мастер-ключ! \nВаш мастер-ключ: ".$registration_key." \nВведите его после авторизации на сайте \nИли перейдите по прямой ссылке: \n\n".$config['home']."/pages/key.php?act=inkey&key=".$registration_key." \n\nЕсли в течении 24 часов вы не подтвердите регистрацию, ваш профиль будет автоматически удален";
						}

						if ($config['regkeys'] == 2) {
							echo '<b><span style="color:#ff0000">Внимание! Ваш аккаунт будет активирован только после проверки администрацией!</span></b><br /><br />';

							$regmessage .= "Внимание! \nВаш аккаунт будет активирован только после проверки администрацией! \nПроверить статус активации вы сможете после авторизации на сайте";
						}


						// ----------------------------------------------------------------------------------//
						$attributes = array(
							'login' => $login,
							'password' => md5(md5($password)),
							'email' => $email,
							'gender' => $gender,
							'themes' => 0,
							'postguest' => $config['bookpost'],
							'postnews' => $config['postnews'],
							'postprivat' => $config['privatpost'],
							'postforum' => $config['forumpost'],
							'themesforum' => $config['forumtem'],
							'point' => 0,
							'money' => $config['registermoney'],
							'confirmreg' => $config['regkeys'],
							'confirmregkey' => $registration_key,
						);

						$user = User::create($attributes);

						// Активация пригласительного ключа
						if (!empty($config['invite'])){
							$invitation->used = 1;
							$invitation->invited_user_id = $current_user->id;
							$invitation->save();
						}

						// ------------------------------ Уведомление в приват ----------------------------------//
						$textpriv = text_private(1, array('%USERNAME%'=>$login, '%SITENAME%'=>$config['home']));

						// исправить
						$config['nickname'] = 1;
						send_private($current_user->id, $config['nickname'], $textpriv);

						if (!empty($config['regmail'])) {
							addmail($email, 'Регистрация на сайте '.$config['title'], $regmessage);
						}

						// ----------------------------------------------------------------------------------------//
						$_SESSION['reguser'] = 1;
						render('pages/registration_register', compact('login', 'password'));

					} else {
						show_error($validation->errors);
					}

					render('includes/back', array('link' => 'registration.php', 'title' => 'Вернуться'));
				break;

			default:
				redirect("registration.php");
			endswitch;

		} else {
			show_error('Ошибка! Вы уже регистрировались. Запрещено регистрировать несколько аккаунтов!');
		}
	} else {
		show_error('Вы уже регистрировались, нельзя регистрироваться несколько раз!');
	}
} else {
	show_error('Регистрация временно приостановлена, пожалуйста зайдите позже!');
}

include_once ('../themes/footer.php');
?>
