<?php
class User extends BaseModel {

	static $table_name = 'users';

	public $captcha;
	public $token;
	public $old_password;
	public $new_password;

	/**
	 * Список статусов
	 * @var array список статусов
	 */
	public static $levelList = [
		'banned' => 'Забаненный',
		'guest' => 'Зарегистрированный',
		'user' => 'Пользователь',
		'moder' => 'Модератор',
		'admin' => 'Администратор',
	];

	static $validates_size_of = [
		['login', 'within' => [3, 20], 'too_short' => 'Слишком короткий логин, минимум %d симв.', 'too_long' => 'Слишком длинный логин, максимум %d симв.'],
		['new_password', 'minimum' => 6, 'allow_null' => true, 'too_short' => 'Слишком короткий пароль, минимум %d симв.'],
	];

	static $validates_uniqueness_of = [
		['login', 'message' => 'Пользователь с данным логином уже зарегистрирован'],
		['email', 'message' => 'Пользователь с данным email уже зарегистрирован'],
	];

	static $validates_inclusion_of = [
		['level', 'in' => ['banned', 'guest', 'user', 'moder', 'admin'], 'message' => 'Неверно указан уровень пользователя'],
		['gender', 'in' => ['male', 'female'], 'message' => 'Неверно указан пол пользователя'],
	];

	static $validates_format_of = [
		['login', 'with' => '/^[a-z0-9_\-]+$/i', 'message' => 'Неверный формат логина (Разрешены символы [0-9a-z_-])'],
		['email', 'with' => '/^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$/', 'message' => 'Неверный формат адреса email'],
		//['phone', 'with' => '/^\+[0-9]{11,12}$/', 'message' => 'Неверный формат номера телефона, пример +7 (900) 123-45-67'],
	];

	/**
	 * Валидация данных
	 */
	public function validate()
	{
		//if ($this->is_new_record()) {
		//  Проверка капчи
		if ($this->captcha && $this->captcha != $_SESSION['captcha']) {
			$this->errors->add('captcha', 'Неверный проверочный код');
		}
		//}
		//
		if ($this->token && $this->token != $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}

		if ($this->old_password && !password_verify($this->old_password, $this->password)) {
			$this->errors->add('old_password', 'Старый пароль не совпадает');
		}
	}

	/**
	 * Метод вызываемый перед сохранением
	 */
	function before_save()
	{
		if ($this->new_password) {
			$this->password = password_hash($this->new_password, PASSWORD_BCRYPT);
		}
	}

	/**
	 * Данные пользователя
	 * @param  string $key название поля в таблице
	 * @return string|object данные пользователя
	 */
	public static function get($key = null)
	{
		if (Registry::has('user')) {
			$user = Registry::get('user');
			return $key ? $user->$key : $user;
		}
	}

	/**
	 * Проверка авторизован ли пользователь
	 * @return boolean авторизован ли пользователь
	 */
	public static function check()
	{
		return (self::get('id') !== null);
	}

	/**
	 * Проверяет является ли пользователь администатором
	 * @return boolean результат проверки
	 */
	public static function isAdmin()
	{
		return in_array(self::get('level'), ['moder', 'admin']);
	}

	/**
	 * Возвращает логин пользователя
	 * @return string логин пользователя
	 */
	public function getLogin()
	{
		return $this->login ? $this->login : 'Гость';
	}

	/**
	 * Возвращает пол пользователя
	 * @return string пол пользователя
	 */
	public function getGender()
	{
		return $this->gender == 'male' ? 'Мужской' : 'Женский';
	}

	/**
	 * Рейтинг пользователя
	 * @return string рейтинг
	 */
	public function getRating()
	{
		if ($this->rating > 0) {
			return '<span class="text-success strong">+'.$this->rating.'</span>';
		} elseif ($this->rating < 0) {
			return '<span class="text-danger strong">-'.$this->rating.'</span>';
		} else {
			return '<span class="strong">0</span>';
		}
	}

	/**
	 * Возвращает аватар пользователя
	 * @return string аватар пользователя
	 */
	public function getAvatar()
	{
		if ($this->avatar) {
			return '<img src="/uploads/users/avatars/'.$this->avatar.'" alt="" class="img-rounded"> ';
		}

		return '<img src="/assets/img/avatars/noavatar.png" alt=""> ';
	}

	/**
	 * Возвращает фото пользователя
	 * @return string фото пользователя
	 */
	public function getPhoto()
	{
		if ($this->avatar) {
			return '<a href="/uploads/users/photos/'.$this->avatar.'" class="gallery"><img src="/uploads/users/thumbs/'.$this->avatar.'" alt=""></a>';
		}
	}

	/**
	 * Уровень пользователя
	 * @return string уровень
	 */
	public function getLevel()
	{
		return self::$levelList[$this->level];
	}

	/**
	 * Статус пользователя
	 * @return string статус
	 */
	public function getStatus()
	{
		if ($this->status) {
			return 'Статус';
		} else {
			return 'Новичок';
			//SELECT `users_login`, `users_status`, `status_name`, `status_color` FROM `users` LEFT JOIN `status` ON `users_point` BETWEEN `status_topoint` AND `status_point`
		}
	}

	/**
	 * Авторизация через социальные сети
	 * @param string $token идентификатор Ulogin
	 */
	public static function socialLogin($token)
	{
		$curl = new Curl();
		$network = $curl->get('http://ulogin.ru/token.php', [
			'token' => $token,
			'host' => $_SERVER['HTTP_HOST']
		]);

		if ($network && empty($network->error)) {
			$_SESSION['social'] = $network;

			$social = Social::find_by_network_and_uid($network->network, $network->uid);
			if ($social && $social->user()) {

				//$_SESSION['ip'] = Registry::get('ip');
				$_SESSION['id'] = $social->user()->id;
				$_SESSION['pass'] = md5(env('APP_KEY').$social->user()->password);

				App::setFlash('success', 'Добро пожаловать, '.e($social->user()->login).'!');
				App::redirect('/');
			}
		}
	}

	/**
	 * Авторизация пользователя
	 * @param  string  $login    Логин или email пользователя
	 * @param  string  $password Пароль пользователя
	 * @param  boolean $remember Чужой компьютер
	 * @return boolean           Результат авторизации
	 */
	public static function login($login, $password, $remember = true)
	{
		if (!empty($login) && !empty($password)) {
			$field = strpos($login, '@') ? 'email' : 'login';

			$user = User::first(array('conditions' => array("$field=?", $login)));

			if ($user && password_verify($password, $user->password)) {

				if ($remember) {
					setcookie('id', $user->id, time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST'], null, true);
					setcookie('pass', md5($user->password.env('APP_KEY')), time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST'], null, true);
				}

				$user->update_attribute('reset_code', null);

				$_SESSION['id'] = $user->id;
				$_SESSION['pass'] = md5(env('APP_KEY').$user->password);

				if (!empty($_SESSION['social'])) {
					$social = new Social();
					$social->user_id = $user->id;
					$social->network = $_SESSION['social']->network;
					$social->uid = $_SESSION['social']->uid;
					$social->save();
				}

				return $user;
			}
		}

		return false;
	}

	/**
	 * Удаление сохраненных изображений
	 * @return boolean результат выполнения
	 */
	public function deleteImages()
	{
		if ($this->avatar) {
			if (file_exists(HOME.'/uploads/users/photos/'.$this->avatar)){
				unlink(HOME.'/uploads/users/photos/'.$this->avatar);
			}

			if (file_exists(HOME.'/uploads/users/thumbs/'.$this->avatar)){
				unlink(HOME.'/uploads/users/thumbs/'.$this->avatar);
			}

			if (file_exists(HOME.'/uploads/users/avatars/'.$this->avatar)){
				unlink(HOME.'/uploads/users/avatars/'.$this->avatar);
			}
		}
		return true;
	}
}
