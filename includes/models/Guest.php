<?php
class Guest extends BaseActiveRecord {

	static $table_name = 'guest';

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
