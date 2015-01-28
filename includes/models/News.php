<?php
class News extends BaseActiveRecord {

	static $table_name = 'news';

	static $belongs_to = array(
		array('user'),
	);

}
