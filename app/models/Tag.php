<?php
class Tag extends BaseModel {

	static $has_many = array(
		'news_tags',
		['news', 'through' => 'news_tags'],
	);


}
