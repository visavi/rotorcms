<?php

Class AdminController Extends BaseController {

	/**
	 * Приборная панель
	 */
	public function index()
	{
		App::view('admin.index');
	}
}
