<?php
class Topic extends BaseModel {

	static $table_name = 'topics';

	public $token;

	/**
	 * Связи
	 */
	static $has_many = [
		['posts', 'order' => 'created_at'],
	];

	static $belongs_to = [
		['forum'],
		['user'],
	];

	static $has_one = [
		['post_count', 'select' => 'count(*) as count, topic_id', 'class' => 'Post'],
		['post_last', 'order' => 'created_at DESC', 'class' => 'Post'],
	];

	/* Валидаторы */
	static $validates_size_of = [
		['title', 'minimum' => 5, 'too_short' => 'Слишком короткое название темы, минимум %d симв.'],
		['title', 'maximum' => 50, 'too_long' => 'Слишком длинное название темы, максимум %d симв.'],
		['note', 'maximum' => 250, 'message' => 'Слишком длинная заметка темы (до %d симв.)'],
	];

	static $validates_numericality_of = [
		['forum_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Не указан раздел форума'],
		['user_id', 'greater_than' => 0, 'only_integer' => true, 'message' => 'Пользователь не авторизован'],
	];

	public function validate() {

		//  Проверка токена
		if ($this->token && $this->token != $_SESSION['token']) {
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
	 * Последнее сообщение в теме
	 * @return object Post модель сообщений
	 */
	public function postLast() {
		return $this->post_last ? $this->post_last : new Post;
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
			$icon = 'fa-lock';
		elseif ($this->locked)
			$icon = 'fa-thumb-tack';
		else
			$icon = 'fa-folder-open';

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

	/**
	 *  Проверяет имеется ли тема в закладках
	 * @param  integer  $user_id id пользователя
	 * @return boolean  имеется ли тема в закладках
	 */
	public function isBookmarked($user_id) {
		return Bookmark::exists([
			'conditions' => ['topic_id = ? AND user_id = ?', $this->id, $user_id],
		]);
	}
}
