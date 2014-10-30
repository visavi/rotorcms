<?php
class Forum extends BaseActiveRecord {

	static $table_name = 'forums';

	static $has_many = array(
		array('parents', 'foreign_key' => 'parent_id', 'class' => 'Forum'),
	);

	static $has_one = array(
		array('topic', 'order' => 'created_at', 'class' => 'Topic'),
		array('topic_count', 'select' => 'count(*) as count, forum_id', 'class' => 'Topic'),
	);

	public function topic() {
		return $this->topic ? $this->topic : new Topic;
	}

	public function topicCount() {
		return $this->topic_count ? $this->topic_count->count : 0;
	}
}
