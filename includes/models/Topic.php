<?php
class Topic extends BaseActiveRecord {

	public $token;
	static $table_name = 'topics';

	/**
	 * Связи
	 */
	static $has_many = array(
		array('posts', 'order' => 'created_at'),
	);

	static $belongs_to = array(
		array('forum'),
		array('user'),
	);

	static $has_one = array(
		array('post_count', 'select' => 'count(*) as count, topic_id', 'class' => 'Post'),
	);

	/* Валидаторы */
	static $validates_size_of = array(
		array('title', 'within' => array(5, 50), 'message' => 'Слишком длинное или короткое название темы (от 5 до 50 симв.)'),
		array('note', 'maximum' => 250, 'message' => 'Слишком длиная заметка темы (до 250 симв.)'),
	);

	static $validates_numericality_of = array(
		array('forum_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Не указан раздел форума'),
		array('user_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Пользователь не авторизован'),
	);

	public function validate() {

		//  Проверка токена
		if ($this->token != $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}

		// Проверка существования раздела
		if (!$this->forum) {
			$this->errors->add('forum', 'Раздела для новой темы не существует!');
		}

		// Проверка на доступность
		if ($this->forum()->closed) {
			$this->errors->add('closed', 'В данном разделе запрещено создавать темы!');
		}
	}

//TODO Антифлуд

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
	 * Данные форума
	 * @return object Forum модель форума
	 */
	public function forum() {
		return $this->forum ? $this->forum : new Forum;
	}

	/**
	 * Выводит определенную иконку в зависимости от статуса
	 * @return string Иконка топика
	 */
	public function getIcon() {

		if ($this->closed)
			$icon = 'glyphicon-lock';
		elseif ($this->locked)
			$icon = 'glyphicon-pushpin';
		else
			$icon = 'glyphicon-folder-open';

		return $icon;
	}

	/**
	 * Список модераторов темы
	 * @return string  список модераторов
	 */
	public function getModerators() {

		$moderators = null;
		$mods = explode(',', $this->mods);
		//$topics['is_moder'] = (in_array($log, $topics['curator'])) ? 1 : 0;
		foreach ($mods as $key => $mod) {
			$comma = (empty($key)) ? '' : ', ';

			$moderators .= $comma.$mod;
		}
		return $moderators;
	}
}
