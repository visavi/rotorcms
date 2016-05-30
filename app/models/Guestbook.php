<?php
class Guestbook extends BaseModel {

	static $table_name = 'guestbook';

	public $token;
	public $captcha;
	public $scenario;

	static $belongs_to = [
		'user',
	];

	static $validates_presence_of = [
		['reply', 'message' => 'Необходимо заполнить поле ответ', 'scenario' => 'reply'],
	];

	/**
	 *	В будещем сделать из конфига $config['guesttextlength']
	 */
	static $validates_size_of = [
		['text', 'minimum' => 5, 'too_short' => 'Слишком короткий текст сообщения, минимум %d симв.'],
		['text', 'maximum' => 2000, 'too_long' => 'Слишком длинный текст сообщения, максимум %d симв.'],
 	];

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
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user()
	{
		return $this->user ? $this->user : new User;
	}

	/**
	 * Функция вызываемая перед методом save
	 */
	public function before_save()
	{
		//$this->text = antimat($this->text);
	}
}
