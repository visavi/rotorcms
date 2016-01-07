<?php

Class GuestbookController Extends BaseController {

	/**
	 * Гостевая книга
	 */
	public function index()
	{
		$page = App::paginate(Setting::get('guestbook_per_page'), Guestbook::count());

		$posts = Guestbook::with('user')
			->orderBy('id', 'desc')
			->offset($page['offset'])
			->limit($page['limit'])
			->get();

		App::view('guestbook.index', compact('posts', 'page'));
	}

	/**
	 * Публикация сообщения
	 */
	public function create()
	{
		$guest = new Guestbook();
		$guest->token = Request::input('token', true);
		$guest->captcha = Request::input('captcha');
		$guest->user_id = User::getUser('id');
		$guest->text = Request::input('text');
		$guest->ip = App::getClientIp();
		$guest->brow = App::getUserAgent();

		if ($guest->save()) {

			// Вынести в after_save
			if (User::check()) {
				$user = User::getUser();
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
		if (! User::check()) App::abort(403);
		if (! $guest = Guestbook::find($id)) App::abort('default', 'Сообщение не найдено!');

		if (! User::isAdmin() && $guest->user_id != User::getUser('id')) {
			App::abort('default', 'Редактирование невозможно, вы не автор данного сообщения!');
		}

		if (! User::isAdmin() && $guest->created_at < Carbon::now()->subMinutes(10)) {
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

	/**
	 * Ответ на сообщение для администрации
	 */
	public function reply($id)
	{
		if (! User::isAdmin()) App::abort(403);
		if (! $guest = Guestbook::find($id)) App::abort('default', 'Сообщение не найдено!');

		if (Request::isMethod('post')) {
			$guest->scenario = 'reply';
			$guest->token = Request::input('token', true);
			$guest->reply = Request::input('text');

//var_dump($guest); exit;
			if ($guest->save()) {
				App::setFlash('success', 'Ответ успешно добавлен!');
				App::redirect('/guestbook');
			} else {
				App::setFlash('danger', $guest->getErrors());
				App::setInput($_POST);
			}
		}

		App::view('guestbook.reply', compact('guest'));
	}

	/**
	 * Удаление сообщения
	 */
	public function delete()
	{
		if (! Request::ajax()) App::redirect('/');
		if (! User::isAdmin()) App::abort(403);

		$id = Request::input('id');
		$guest = Guestbook::find($id);

		exit(json_encode(['status' => $guest->delete() ? 'ok' : 'error']));

	}
}
