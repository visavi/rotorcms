<?php

Class GuestbookController Extends BaseController {

	/**
	 * Гостевая книга
	 */
	public function index()
	{
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$total = Guest::count();

		if ($total > 0 && ($page * Setting::get('guestbook_per_page')) >= $total) {
			$page = ceil($total / Setting::get('guestbook_per_page'));
		}

		$offset = intval(($page * Setting::get('guestbook_per_page')) - Setting::get('guestbook_per_page'));

		$posts = Guest::all([
			'offset' => $offset,
			'limit' => Setting::get('guestbook_per_page'),
			'order' => 'created_at desc',
			'include' => array('user'),
		]);

		App::view('guestbook.index', compact('posts', 'page', 'total'));
	}
}
