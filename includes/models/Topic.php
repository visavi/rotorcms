<?php
class Topic extends BaseActiveRecord {

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
}
