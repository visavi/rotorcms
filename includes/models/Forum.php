<?php
class Forum extends BaseActiveRecord {

	static $table_name = 'forums';

	/**
	 * Связи
	 */
	static $has_many = array(
		array('topics', 'order' => 'created_at'),
		array('children', 'foreign_key' => 'parent_id', 'class' => 'Forum'),
	);

	static $belongs_to = array(
		array('parent', 'foreign_key' => 'parent_id', 'class' => 'Forum'),
	);

	static $has_one = array(
		array('topic_last', 'order' => 'created_at', 'class' => 'Topic'),
		array('topic_count', 'select' => 'count(*) as count, forum_id', 'class' => 'Topic'),
	);

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
}
