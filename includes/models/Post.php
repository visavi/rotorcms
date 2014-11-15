<?php
class Post extends BaseActiveRecord {

	public $token;
	static $table_name = 'posts';

	static $belongs_to = array(
		array('topic'),
		array('user'),
	);

	/* Валидаторы */
	static $validates_size_of = array(
		//$config['forumtextlength']
		array('text', 'within' => array(5, 1500), 'message' => 'Слишком длинное или короткое сообщение (от 5 до 1500 симв.)'),
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
