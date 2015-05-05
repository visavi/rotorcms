<?php

Class GuestbookController Extends BaseController {

	/**
	 * Гостевая книга
	 */
	public function index()
	{
		$total = Guestbook::count();
		$page = getPage(Setting::get('guestbook_per_page'), $total);

		$posts = Guestbook::all([
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 'created_at desc',
			'include' => ['user'],
		]);

		App::view('guestbook.index', compact('posts', 'page'));
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
		$guest->brow = App::getUserAgent();

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

	/**
	 *  Редактирование сообщения
	 */
	public function edit($id)
	{
		if (!User::check()) App::abort(403);

		if (!$guest = Guestbook::find_by_id_and_user_id($id, User::get('id'))) App::abort('default', 'Сообщение не найдено!');

		if ($guest->created_at < Carbon::now()->subMinutes(10)) {
			App::abort('default', 'Редактирование невозможно, прошло более 10 мин.');
		}

		if (Request::isMethod('post')) {

			$guest->token = Request::input('token', true);
			$guest->text = Request::input('text');

			if ($guest->save()) {
				App::setFlash('success', 'Сообщение успешно изменено!');
				App::redirect('/guestbook');
			} else {
				App::setFlash('danger', $guest->getErrors());
				App::setInput($_POST);
			}
		}

		App::view('guestbook.edit', compact('guest'));
	}
}
