<?php
class Topic extends BaseActiveRecord {

	static $table_name = 'topics';

	static $belongs_to = array(
		array('user')
	);

	static $has_one = array(
		array('post_count', 'select' => 'count(*) as count, topic_id', 'class' => 'Post'),
	);

	public function postCount() {
		return $this->post_count ? $this->post_count->count : 0;
	}

	public function user() {
		return $this->user ? $this->user : new User;
	}
}
