<?php

Abstract Class BaseController {

	public function __construct()
	{
		if (User::check() && User::get('level') == 'banned' && App::requestUrl(true) != '/logout') {
			App::abort('default', 'Вы забанены');
		}
	}
}
