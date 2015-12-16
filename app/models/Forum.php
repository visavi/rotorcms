<?php
class Forum extends BaseModel {

	static $table_name = 'forums';

	/**
	 * Связи
	 */
	static $has_many = [
		['topics', 'order' => 'locked DESC, created_at DESC'],
		['children', 'foreign_key' => 'parent_id', 'order' => 'sort DESC', 'class' => 'Forum'],
	];

	static $belongs_to = [
		['parent', 'foreign_key' => 'parent_id', 'class' => 'Forum'],
		['topic_last', 'foreign_key' => 'topic_last_id', 'class' => 'Topic'],
	];

	static $has_one = [
		['topic_count', 'select' => 'count(*) as count, forum_id', 'group' => 'forum_id', 'class' => 'Topic'],
		['post_count', 'select' => 'count(*) as count, forum_id', 'group' => 'forum_id', 'class' => 'Post'],
	];

	/**
	 * Родительский форум
	 * @return object Forum модель форума
	 */
	public function parent() {
		return $this->parent ? $this->parent : new Forum;
	}

	/**
	 * Список тем форума
	 * @return object Topic модель темы
	 */
	public function topics() {
		return $this->topics ? $this->topics : new Topic;
	}

	/**
	 * Последняя тема в разделе
	 * @return object Topic модель темы
	 */
	public function topicLast() {
		return $this->topic_last ? $this->topic_last : new Topic;
	}

	/**
	 * Количество тем в разделе
	 * @return integer количество тем в разделе
	 */
	public function topicCount() {
		return $this->topic_count ? $this->topic_count->count : 0;
	}

	/**
	 * Количество сообщений в разделе
	 * @return integer количество тем в разделе
	 */
	public function postCount() {
		return $this->post_count ? $this->post_count->count : 0;
	}

	/**
	 * Список всех разделов
	 * @return array ассоциативный массив разделов
	 */
	public static function getAll()
	{
		return self::all(['conditions' => ['parent_id = ? AND closed = ?', 0, 0], 'order' => 'sort', 'include' => ['children']]);

		//return App::arrayAssoc($forums, 'id', 'title');
	}
}
