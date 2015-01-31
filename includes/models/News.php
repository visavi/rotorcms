<?php
class News extends BaseActiveRecord {

	static $table_name = 'news';

	static $has_many = array(
		array('comments', 'foreign_key' => 'service_id', 'conditions' => array('type = ?', 'news'), 'order' => 'created_at DESC'),
	);

	static $has_one = array(
		array('comment_count', 'foreign_key' => 'service_id', 'conditions' => array('type = ?', 'news'), 'select' => 'count(*) as count, service_id', 'class' => 'Comment'),
	);

	static $belongs_to = array(
		array('user'),
	);

	/**
	 * Количество комментарий новости
	 * @return integer количество комментарий новости
	 */
	public function commentCount() {
		return $this->comment_count ? $this->comment_count->count : 0;
	}
}
