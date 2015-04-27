<?php
class Guestbook extends BaseModel {

	static $table_name = 'guest';

	public $token;
	public $captcha;

	static $belongs_to = array(
		array('user'),
	);

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user() {
		return $this->user ? $this->user : new User;
	}

	//$config['guesttextlength']
	static $validates_size_of = array(
		array('text', 'minimum' => 5, 'too_short' => 'Слишком короткий текст сообщения, минимум %d симв.'),
		array('text', 'maximum' => 2000, 'too_long' => 'Слишком длинный текст сообщения, максимум %d симв.'),
 	);

	public function validate() {

		//  Проверка токена
		if ($this->token && $this->token != $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}

		if (!User::check() && $this->captcha != $_SESSION['captcha']) {
			$this->errors->add('captcha', 'Неверный проверочный код');
		}
	}

	/**
	 * Функция вызываемая перед методом save
	 */
	public function before_save()
	{
		//$this->text = antimat($this->text);
	}
}
