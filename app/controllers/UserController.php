<?php

Class UserController Extends BaseController {

	/**
	 * Список пользователей
	 */
	public function index()
	{
		$list = Request::input('list', 'all');
		$login = Request::input('login');

		if (Request::isMethod('post')) {
			$users = User::all(array('select' => 'login', 'order' => 'point DESC, login ASC'));
			foreach ($users as $key => $val) {
				if (strtolower($login) == strtolower($val->login)) {
					$position = $key + 1;
				}
			}

			if (isset($position)) {
				$page = ceil($position / Setting::get('users_per_page'));

				App::setFlash('success', 'Позиция в рейтинге: '.$position);
				App::redirect("/users?page=$page&login=$login");
			} else {
				App::setFlash('danger', 'Пользователь с данным логином не найден!');
			}
		}

		$count['users'] = $total = User::count();
		$count['admins'] = User::count(['conditions' => ['level in (?)', ['moder', 'admin']]]);

		$condition = [];

		if ($list == 'admins') {
			$total = $count['admins'];
			$condition = ['level IN(?)', ['moder', 'admin']];
		}

		$page = App::paginate(Setting::get('users_per_page'), $total);

		$users = User::all(array(
			'conditions' => $condition,
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 'point DESC, login ASC',
		));

		App::view('users.index', compact('users', 'page', 'count', 'list', 'login'));
	}

	/**
	 * Профиль пользователя
	 */
	public function view($login)
	{
		if (!$user = User::find_by_login($login)) App::abort('default', 'Пользователь не найден!');

		App::view('users.profile', compact('user'));
	}

	/**
	 * Редактирование профиля
	 */
	public function edit()
	{
		if (!User::check()) App::abort(403);

		$user = User::get();

		if (Request::isMethod('post')) {

			$user->token = Request::input('token', true);
			$user->email = Request::input('email');
			$user->gender = Request::input('gender');

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
		if (Request::isMethod('post')) {

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

		if (Request::isMethod('post') && !Request::has('token')) {

			$captcha = Request::input('captcha');
			$login = Request::input('login');
			$email = Request::input('email');
			$password = Request::input('password');
			$gender = Request::input('gender');

			$user = new User();
			$user->captcha = $captcha;
			$user->login = $login;
			$user->new_password = $password;
			$user->email = $email;
			$user->gender = $gender;

			if ($user->save()) {

				$message = 'Добро пожаловать, '.e($login).'<br>Теперь вы зарегистрированный пользователь сайта '.Setting::get('sitelink').' , сохраните ваш пароль в надежном месте<br>Ваши данные для входа на сайт<br>Email: '.e($email).'<br>Пароль: '.e($password).'<br>Если это письмо попало к вам по ошибке, то просто проигнорируйте его';

				$to = [$email => $login];
				$subject = 'Регистрация на сайте';
				$body = App::view('mailer.register', compact('subject', 'message'), true);

				// Отправка письма
				App::sendMail($to, $subject, $body);

				// Авторизация
				User::login($email, $password);

				App::setFlash('success', 'Добро пожаловать, '.e($user->login).'! Вы успешно зарегистрированы!');
				App::redirect('/');

			} else {
				App::setFlash('danger', $user->getErrors());
				App::setInput($_POST);
				App::redirect('/register');
			}
		}

		if (Request::has('token')) {
			User::socialAuth(Request::input('token'));
		}

		App::view('users.register');
	}

	/**
	 * Авторизация
	 */
	public function login()
	{
		$return = Request::input('return', '');
		if (User::check()) App::redirect('/');

		if (Request::has('login') && Request::has('password')) {

			$login = Request::input('login');
			$password = Request::input('password');
			$remember = Request::has('remember') ? 1 : 0;

			if ($user = User::login($login, $password, $remember)) {
				App::setFlash('success', 'Добро пожаловать, '.e($user->login).'!');
				if ($return) { App::redirect($return); } else { App::redirect('/'); }
			}

			App::setInput($_POST);
			App::setFlash('danger', 'Ошибка авторизации. Неправильный логин или пароль!');
			App::redirect('/login');
		}

		if (Request::has('token')) {
			User::socialLogin(Request::input('token'));
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

		if (Request::isMethod('post')) {

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

				$message = 'Здравствуйте, '.e($user->login).'<br />Вами была произведена операция по восстановлению пароля на сайте '.Setting::get('sitelink').'<br />Для того, чтобы восстановить пароль, необходимо нажать на кнопку восстановления<br /><br />Если это письмо попало к вам по ошибке или вы не собираетесь восстанавливать пароль, то просто проигнорируйте его';

				$to = [$user->email => $user->login];
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

			if (Request::isMethod('post')) {

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
	 * Загрузка фото в профиль
	 */
	public function image()
	{
		if (!Request::ajax() || !User::check()) App::redirect('/');
		// Удаление и размер
		$image = Request::file('image');

		if ($image->isValid()) {

			$ext = $image->getClientOriginalExtension();

			if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])) {

				$filename = uniqid(mt_rand()).'.'.$ext;

				$user = User::get();
				$user->deleteImages();

				$img = new SimpleImage($image->getPathName());
				$img->best_fit(1280, 1280)->save('uploads/users/photos/'.$filename);
				$img->best_fit(200, 200)->save('uploads/users/thumbs/'.$filename);
				$img->thumbnail(48, 48)->save('uploads/users/avatars/'.$filename);

				$user->avatar = $filename;
				if ($user->save())
					exit(json_encode(['status' => 'uploaded']));
				else
					exit(json_encode(['status' => 'nosave']));
			} else {
				exit(json_encode(['status' => 'invalid']));
			}
		}
	}

}
