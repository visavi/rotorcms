<?php
class Bookmark extends BaseActiveRecord {

	static $table_name = 'bookmarks';

	static $belongs_to = array(
		array('topic'),
	);

	/**
	 * Данные темы
	 * @return object Topic модель топика
	 */
	public function topic() {
		return $this->topic ? $this->topic : new Topic;
	}

}
