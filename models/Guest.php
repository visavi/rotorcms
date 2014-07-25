<?php
class Guest extends ActiveRecord\Model {

	static $table_name = 'guest2';

	static $belongs_to = array(
		array('user')
	);

	static $delegate = array(
		array('id', 'login', 'to' => 'user', 'prefix' => 'user')
	);
}
