<?php
class Online extends BaseActiveRecord {

	static $table_name = 'online2';

	static $belongs_to = array(
		array('user')
	);

	public function user()
	{
		return ($this->user) ? $this->user : new User;
	}
}
