<?php

Class UserController Extends BaseController {

	/**
	 * Профиль пользователя
	 */
	public function view($id)
	{
		$user = User::find_by_id($id);

		App::view('users.profile', compact('user'));
	}

	/**
	 * Редактирование профиля
	 */
	public function edit()
	{
		if (!User::check()) App::abort(403);

		$user = User::get();

		if (App::requestMethod() == 'POST') {

			$user->token = Request::input('token', true);
			$user->email = Request::input('email');
			$user->first_name = Request::input('first_name');
			$user->last_name = Request::input('last_name');
			$user->middle_name = Request::input('middle_name');
			$user->phone = Request::input('phone');
			$user->company_name = Request::input('company_name');
			$user->company_address = Request::input('company_address');
			$user->company_inn = Request::input('company_inn');
			$user->company_kpp = Request::input('company_kpp');
			$user->company_ogrn = Request::input('company_ogrn');
			$user->info = Request::input('info');

			if ($user->save()) {
				App::setFlash('success', 'Данные успешно сохранены!');

			} else {
				App::setFlash('danger', $user->getErrors());
				App::setInput($_POST);
			}

			App::redirect('/user/edit');
		}

		App::view('users.edit', compact('user'));
	}

	/**
	 * Изменение пароля
	 */
	public function password()
	{
		if (!User::check()) App::abort(403);

		$user = User::get();

		if (App::requestMethod() == 'POST') {

			$old_password = Request::input('old_password');
			$new_password = Request::input('new_password');

			$user->old_password = $old_password;
			$user->new_password = $new_password;
			$user->updated_at = new Datetime;

			if ($user->save()) {

				User::login($user->email, $new_password);
				App::setFlash('success', 'Пароль успешно изменен!');

			} else {
				App::setFlash('danger', $user->getErrors());
				App::setInput($_POST);
			}

			App::redirect('/user/password');
		}

		App::view('users.password', compact('user'));
	}

	/**
	 * Регистрация
	 */
	public function register()
	{
		if (User::check()) App::redirect('/');

		if (App::requestMethod() == 'POST') {

			$first_name = Request::input('first_name');
			$email = Request::input('email');
			$password = Request::input('password');
			$phone = Request::input('phone');
			$captcha = Request::input('captcha');

			$user = new User;
			$user->captcha = $captcha;
			$user->email = $email;
			$user->new_password = $password;
			$user->first_name = $first_name;
			$user->phone = $phone;

			if ($user->save()) {

				$message = 'Добро пожаловать, '.e($first_name).'<br>Теперь вы зарегистрированный пользователь сайта '.Setting::get('sitelink').' , сохраните ваш пароль в надежном месте<br>Ваши данные для входа на сайт<br>Email: '.e($email).'<br>Пароль: '.e($password).'<br>Если это письмо попало к вам по ошибке, то просто проигнорируйте его';

				$to = [$email => $first_name];
				$subject = 'Регистрация на сайте';
				$body = App::view('mailer.register', compact('subject', 'message'), true);

				// Отправка письма
				App::sendMail($to, $subject, $body);

				// Авторизация
				User::login($email, $password);

				App::setFlash('success', 'Добро пожаловать, '.e($user->first_name).'! Вы успешно зарегистрированы!');
				App::redirect('/');

			} else {
				App::setFlash('danger', $user->getErrors());
				App::setInput($_POST);
				App::redirect('/register');
			}
		}

		App::view('users.register');
	}

	/**
	 * Авторизация
	 */
	public function login()
	{
		$return = isset($_GET['return']) ? $_GET['return'] : '';

		if (User::check()) App::redirect('/');

		if (isset($_POST['email']) && isset($_POST['password'])) {

			$email = Request::input('email');
			$password = Request::input('password');
			$remember = Request::has('remember') ? 1 : 0;

			if ($user = User::login($email, $password, $remember)) {
				App::setFlash('success', 'Добро пожаловать, '.$user->first_name.'!');
				if ($return) { App::redirect($return); } else { App::redirect('/'); }
			}

			App::setInput($_POST);
			App::setFlash('danger', 'Ошибка авторизации. Неправильный email или пароль!');
			App::redirect('/login');
		}

		App::view('users.login');
	}

	/**
	 * Выход
	 */
	public function logout()
	{
		$_SESSION = array();
		setcookie('pass', '', time() - 3600, '/', $_SERVER['HTTP_HOST'], null, true);
		setcookie(session_name(), '', time() - 3600, '/', '');
		session_destroy();

		App::redirect('/');
	}

	/**
	 * Восстановление пароля
	 */
	public function recovery()
	{
		if (User::check()) App::abort(403);

		if (App::requestMethod() == 'POST') {

			$email = Request::input('email');
			$captcha = Request::input('captcha');

			$errors = [];
			if (!App::isMail($email)) $errors['email'] = 'Неверный формат адреса email';
			if ($captcha != $_SESSION['captcha']) $errors['captcha'] = 'Неверный проверочный код';

			if (!$errors && !$user = User::find_by_email($email)) $errors['email'] = 'Пользователь не найден';

			if (!$errors) {

				$user->reset_code = str_random(mt_rand(35, 40));
				$user->save();

				$reset_link = 'http://'.Setting::get('sitelink').'/reset?key='.$user->reset_code;

				$message = 'Здравствуйте, '.e($user->first_name).'<br />Вами была произведена операция по восстановлению пароля на сайте '.Setting::get('sitelink').'<br />Для того, чтобы восстановить пароль, необходимо нажать на кнопку восстановления<br /><br />Если это письмо попало к вам по ошибке или вы не собираетесь восстанавливать пароль, то просто проигнорируйте его';

				$to = [$user->email => $user->first_name];
				$subject = 'Восстановление пароля';
				$body = App::view('mailer.recovery', compact('subject', 'message', 'reset_link'), true);

				// Отправка письма
				App::sendMail($to, $subject, $body);

				App::setFlash('success', 'Письмо с инструкцией выслано вам на email!');

			} else {
				App::setFlash('danger', $errors);
				App::setInput($_POST);
			}

			App::redirect('/recovery');
		}

		App::view('users.recovery');
	}

	/**
	 * Сброс пароля
	 */
	public function reset()
	{
		if (User::check()) App::abort(403);

		$key = Request::input('key');

		$errors = [];
		if (!$key) $errors['key'] = 'Отсутствует ключ для сброса пароля';
		if (!$errors && !$user = User::find_by_reset_code($key)) $errors['email'] = 'Пользователь с данным ключем не найден';

		if (!$errors) {

			if (App::requestMethod() == 'POST') {

				$new_password = Request::input('password');

				$user->new_password = $new_password;
				$user->updated_at = new Datetime;

				if ($user->save()) {

					$user->update_attribute('reset_code', null);

					App::setFlash('success', 'Новый пароль успешно сохранен!');
					App::redirect('/');

				} else {
					App::setFlash('danger', $errors);
					App::setInput($_POST);
				}

				App::redirect('/reset');
			}

			App::view('users.reset');

		} else {
			App::setFlash('danger', $errors);
			App::redirect('/');
		}
	}

	/**
	 * Мои заявки
	 */
	public function bids()
	{
		if (!User::check()) App::abort(403);

		$sales = Sale::all([
			'conditions' => ['user_id = ?', User::get('id')],
			'order' => 'updated_at desc',
			'include' => array('user'),
		]);

		$purchases = Purchase::all([
			'conditions' => ['user_id = ?', User::get('id')],
			'order' => 'updated_at desc',
			'include' => array('user'),
		]);

		App::view('users.bids', compact('sales', 'purchases'));
	}
}
