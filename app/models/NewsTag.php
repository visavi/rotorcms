<?php
class NewsTag extends BaseModel {

	static $belongs_to = [
		'tag',
		'news',
	];

}
