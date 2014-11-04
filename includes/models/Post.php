<?php
class Post extends BaseActiveRecord {

	static $table_name = 'posts';

	/* Валидаторы */
	static $validates_size_of = array(
		//$config['forumtextlength']
		array('text', 'within' => array(5, 1500), 'message' => 'Слишком длинное или короткое сообщение (от 5 до 1500 симв.)'),
	);

}
