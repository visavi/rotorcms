<?php
class Guest extends BaseActiveRecord {

	static $table_name = 'guest';

	static $belongs_to = array(
		array('user'),
	);

	/**
	 * @var array названия функций вызываемых перед изменением
	 */
	static $before_save = array('before_save');

	//$config['guesttextlength']
	static $validates_size_of = array(
		array('text', 'minimum' => 5, 'too_short' => 'Слишком короткий текст сообщения, минимум %d симв.'),
		array('text', 'maximum' => 2000, 'too_long' => 'Слишком длинный текст сообщения, максимум %d симв.'),
 	);

	/**
	 * Функция вызываемая перед методом save
	 */
	public function before_save()
	{
		$this->text = antimat($this->text);
	}

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user() {
		return $this->user ? $this->user : new User;
	}
}
