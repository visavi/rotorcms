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
	];

	static $has_one = [
		['topic_last', 'order' => 'created_at', 'class' => 'Topic'],
		['topic_count', 'select' => 'count(*) as count, forum_id', 'class' => 'Topic'],
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
	 * Список всех раздело
	 * @return array ассоциативный массив регионов
	 */
	public static function getAll()
	{
		return App::arrayAssoc(self::all(), 'id', 'title');
	}
}
