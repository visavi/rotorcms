<?php
class User extends BaseActiveRecord {

	static $table_name = 'users2';

	public function getId() {
		return $this->id ? $this->id : 0;
	}

	public function getLogin(){
		return $this->login ? $this->login : 'Гость';
	}

	public function getAvatar() {

		if ($this->avatar) {
			return '<img src="/'.$this->avatar.'" alt="" /> ';
		}

		return '<img src="/images/avatars/noavatar.gif" alt="" /> ';
	}

}
