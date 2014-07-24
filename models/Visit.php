<?php
class Visit extends ActiveRecord\Model {

	static $table_name = 'visit2';

	static $belongs_to = array(
		array('user')
	);

	static $delegate = array(
		array('login', 'to' => 'user')
	);
}
