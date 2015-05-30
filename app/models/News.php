<?php
class News extends BaseModel {

	static $table_name = 'news';

	static $has_many = [
		['comments', 'foreign_key' => 'relate_id', 'conditions' => ['relate_type = ?', 'news'], 'order' => 'created_at DESC'],
	];


	static $has_one = array(
		['comment_count', 'foreign_key' => 'relate_id', 'conditions' => ['relate_type = ?', 'news'], 'select' => 'count(*) as count, relate_id', 'class' => 'Comment'],
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

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user() {
		return $this->user ? $this->user : new User;
	}
}
