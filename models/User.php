<?php
class User extends ActiveRecord\Model {

	static $table_name = 'users2';

	public function getLogin(){
		return $this->login ? $this->login : 'Пользователь удален';
	}

	public function getAvatar(){

		if ($this->avatar) {
			return '<img src="/'.$this->avatar.'" alt="" /> ';
		}

		return '<img src="/images/avatars/noavatar.gif" alt="" /> ';
	}

}
