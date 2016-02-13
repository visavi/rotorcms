<?php
class Guestbook extends BaseModel {

	protected $table = 'guestbook';
	protected $fillable = ['user_id', 'text', 'ip', 'brow'];

	public $token;
	public $captcha;

public static $rules = array(
        'text' => 'required|min:8'
    );

	/**
	 * Связь с пользователями
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function getUser()
	{
		return $this->user ? $this->user : new User;
	}

/*	static $validates_presence_of = [
		['reply', 'message' => 'Необходимо заполнить ответ', 'scenario' => 'reply'],
	];*/

	//$config['guesttextlength']
/*	static $validates_size_of = [
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
	}*/

	/**
	 * Функция вызываемая перед методом save
	 */
//	public function before_save()
//	{
		//$this->text = antimat($this->text);
//	}
}
