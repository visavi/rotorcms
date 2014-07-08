<?php
class User extends ActiveRecord\Model {

	static $table_name = 'users';
	static $primary_key = 'users_id';

	static $alias_attribute = array(
		'first_name' => 'person_first_name',
		'last_name' => 'person_last_name');
	}


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
