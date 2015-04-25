<?php
class Post extends BaseModel {

	public $token;
	static $table_name = 'posts';

	static $belongs_to = array(
		array('forum'),
		array('topic'),
		array('user'),
	);

	/* Валидаторы */
	static $validates_size_of = array(
		//$config['forumtextlength']
		array('text', 'minimum' => 5, 'too_short' => 'Слишком короткое сообщение, минимум %d симв.'),
		array('text', 'maximum' => 3000, 'too_long' => 'Слишком длинное сообщение, максимум %d симв.'),
	);

	static $validates_numericality_of = array(
		array('user_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Пользователь не авторизован'),
	);


	public function validate() {

		//  Проверка токена
		if ($this->token != $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}

		// Проверка существования темы
		if (!$this->topic) {
			$this->errors->add('topic', 'Темы для данного сообщения не существует!');
		}

		// Проверка существования раздела
		if (!$this->forum) {
			$this->errors->add('forum', 'Раздела для данного сообщения не существует!');
		}

		// Проверка на открытость темы
		if ($this->topic()->closed) {
			$this->errors->add('topic', 'Данная тема закрыта для новых сообщений');
		}
	}

	/**
	 * Данные темы
	 * @return object Topic модель топика
	 */
	public function topic() {
		return $this->topic ? $this->topic : new Topic;
	}

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user() {
		return $this->user ? $this->user : new User;
	}
}
