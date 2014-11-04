<?php
class Topic extends BaseActiveRecord {

	public $token;
	static $table_name = 'topics';

	/**
	 * Связи
	 */
	static $belongs_to = array(
		array('forum'),
		array('user'),
	);

	static $has_one = array(
		array('post_count', 'select' => 'count(*) as count, topic_id', 'class' => 'Post'),
	);

	/* Валидаторы */
 	static $validates_inclusion_of = array(
		array('type', 'in' => array('open', 'closed', 'locked')),
	);

	static $validates_size_of = array(
		array('title', 'within' => array(5, 50), 'message' => 'Слишком длинное или короткое название темы (от 5 до 50 симв.)'),
		array('note', 'maximum' => 250, 'message' => 'Слишком длиная заметка темы (до 250 симв.)'),
	);

	static $validates_numericality_of = array(
		array('forum_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Не указан раздел форума'),
		array('user_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Пользователь не авторизован'),
	);

	public function validate() {

		if (!$this->forum) {
			$this->errors->add('forum', 'Раздела для новой темы не существует!');
		}

		if ($this->token != $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}
	}

	/**
	 * @return array индивидуальные метки атрибутов
	 */
/*	public function attributeLabels()
	{
		return array(
			'forum_id' => 'Раздел форума',
			'user_id' => 'ID пользователя',
			'title' => 'Название темы',
			'type' => 'Статус темы',
			'mods' => 'Список кураторов',
			'note' => 'Заметка темы',
			'token' => 'Идентификатор сессии',
		);
	}*/

	/**
	 * Количество сообщений в теме
	 * @return integer количество сообщений в теме
	 */
	public function postCount() {
		return $this->post_count ? $this->post_count->count : 0;
	}

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user() {
		return $this->user ? $this->user : new User;
	}

	/**
	 * Выводит определенную иконку в зависимости от статуса
	 * @return string Иконка топика
	 */
	public function getIcon() {

		if ($this->locked)
			$icon = 'glyphicon-pushpin';
		elseif ($this->closed)
			$icon = 'glyphicon-lock';
		else
			$icon = 'glyphicon-folder-open';

		return $icon;
	}
}
