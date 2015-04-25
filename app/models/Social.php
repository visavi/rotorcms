<?php
class Social extends BaseModel {

	static $table_name = 'socials';

	static $belongs_to = array(
		array('user')
	);

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user() {
		return $this->user ? $this->user : new User;
	}
}
