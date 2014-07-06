<?php
class User extends ActiveRecord\Model {

	static $table_name = 'users';
	static $primary_key = 'users_id';

	public function getLogin(){
		return !empty($this->users_login) ? $this->users_login : 'Пользователь удален';
	}
}
