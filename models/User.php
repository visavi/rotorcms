<?php
class User extends ActiveRecord\Model {

	static $table_name = 'users';
	static $primary_key = 'users_id';

	public function getLogin(){
		return $this->users_login ? $this->users_login : 'Пользователь удален';
	}

	public function getAvatar(){

		if ($this->users_avatar) {
			return '<img src="/'.$this->users_avatar.'" alt="" /> ';
		}

		return '<img src="/images/avatars/noavatar.gif" alt="" /> ';
	}

}
