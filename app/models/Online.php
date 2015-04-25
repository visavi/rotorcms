<?php
class Online extends BaseModel {

	static $table_name = 'online';

	static $belongs_to = array(
		array('user')
	);

	public function user()
	{
		return ($this->user) ? $this->user : new User;
	}
}
