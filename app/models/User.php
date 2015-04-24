<?php
class User extends BaseActiveRecord {

	static $table_name = 'users';


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
		return (self::get('level') == 'admin');
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
	 * Возвращает аватар пользователя
	 * @return string аватар пользователя
	 */
	public function getAvatar()
	{
		if ($this->avatar) {
			return '<img src="/'.$this->avatar.'" alt="" /> ';
		}

		return '<img src="/assets/img/avatars/noavatar.gif" alt="" /> ';
	}

	/**
	 * Авторизация через социальные сети
	 * @param string $token идентификатор Ulogin
	 */
	public static function socialLogin($token){

		$query = curl_connect('http://ulogin.ru/token.php?token='.check($token).'&amp;host='.$_SERVER['HTTP_HOST']);

		$network = json_decode($query, true);

		if ($network && !isset($network['error'])) {
			$_SESSION['social'] = $network;

			$social = Social::find_by_network_and_uid($network['network'], $network['uid']);
			if ($social && $social->user()->id) {

				$_SESSION['ip'] = Registry::get('ip');
				$_SESSION['id'] = $social->user()->id;
				$_SESSION['pass'] = md5(Setting::get('keypass').$social->user()->password);

				notice('Вы успешно авторизованы!');
				redirect('/');
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
					setcookie('pass', md5($user->password.Setting::get('keypass')), time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST'], null, true);
				}

				//$user->update_attribute('reset_code', null);

				$_SESSION['id'] = $user->id;
				$_SESSION['pass'] = md5(Setting::get('keypass').$user->password);

				if (!empty($_SESSION['social'])) {
					$social = new Social;
					$social->user_id = $user->id;
					$social->network = $_SESSION['social']['network'];
					$social->uid = $_SESSION['social']['uid'];
					$social->save();
				}

				return $user;
			}
		}

		return false;
	}


}
