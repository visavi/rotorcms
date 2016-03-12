<?php

Abstract Class BaseController {

	public function __construct()
	{
		if (User::check() && User::get('level') == 'banned' && Request::path() != 'logout') {
			App::abort('default', 'Вы забанены');
		}
	}
}
