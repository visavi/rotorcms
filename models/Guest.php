<?php
class Guest extends ActiveRecord\Model {

	static $table_name = 'guest';

	static $belongs_to = array(
		array('user')
	);
}
