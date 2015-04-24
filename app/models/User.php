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

}
