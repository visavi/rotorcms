<?php
class Guest extends BaseModel {

	static $table_name = 'guest';

	public $token;

	/**
	 * @var array названия функций вызываемых перед сохранением
	 */
	static $before_save = array('before_save');

	static $belongs_to = array(
		array('user'),
	);

	//$config['guesttextlength']
	static $validates_size_of = array(
		array('text', 'minimum' => 5, 'too_short' => 'Слишком короткий текст сообщения, минимум %d симв.'),
		array('text', 'maximum' => 2000, 'too_long' => 'Слишком длинный текст сообщения, максимум %d симв.'),
 	);

	public function validate() {

		//  Проверка токена
		if ($this->user()->id && $this->token != $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}

		//  Антифлуд

	}

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
