<?php

Class GuestbookController Extends BaseController {

	/**
	 * Гостевая книга
	 */
	public function index()
	{
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$total = Guestbook::count();

		if ($total > 0 && ($page * Setting::get('guestbook_per_page')) >= $total) {
			$page = ceil($total / Setting::get('guestbook_per_page'));
		}

		$offset = intval(($page * Setting::get('guestbook_per_page')) - Setting::get('guestbook_per_page'));

		$posts = Guestbook::all([
			'offset' => $offset,
			'limit' => Setting::get('guestbook_per_page'),
			'order' => 'created_at desc',
			'include' => array('user'),
		]);

		App::view('guestbook.index', compact('posts', 'page', 'total'));
	}

	/**
	 * Публикация сообщения
	 */
	public function create()
	{
		$guest = new Guestbook;
		$guest->token = Request::input('token', true);
		$guest->captcha = Request::input('captcha');
		$guest->user_id = User::get('id');
		$guest->text = Request::input('text');

		if ($guest->save()) {

			// Вынести в after_save
			if (User::check()) {
				$user = User::get();
				$user->allguest = $user->allguest + 1;
				$user->point = $user->point + 1;
				$user->money = $user->money + 20;
				$user->save();
			}

			App::setFlash('success', 'Сообщение успешно добавлено!');
		} else {
			App::setFlash('danger', $guest->getErrors());
			App::setInput($_POST);
		}

		App::redirect('/guestbook');
	}
}
