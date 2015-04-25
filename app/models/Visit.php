<?php
class Visit extends BaseModel {

	static $table_name = 'visit';

	static $belongs_to = array(
		array('user')
	);

	static $delegate = array(
		array('login', 'to' => 'user')
	);
}
