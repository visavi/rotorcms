<?php
class User extends BaseActiveRecord {

	static $table_name = 'users';

	public function getId()
	{
		return $this->id ? $this->id : 0;
	}

	public function getLogin()
	{
		return $this->login ? $this->login : 'Гость';
	}

	public function getAvatar()
	{
		if ($this->avatar) {
			return '<img src="/'.$this->avatar.'" alt="" /> ';
		}

		return '<img src="/images/avatars/noavatar.gif" alt="" /> ';
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

				$_SESSION['ip'] = $ip;
				$_SESSION['id'] = $social->user()->id;
				$_SESSION['password'] = md5(Setting::get('keypass').$social->user()->password);

				notice('Вы успешно авторизованы!');
				redirect('/');
			}
		}
	}

}
