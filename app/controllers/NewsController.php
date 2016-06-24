<?php

Class NewsController Extends BaseController {

	/**
	 * Список новостей
	 */
	public function index()
	{
		$total = News::count();

		$page = App::paginate(Setting::get('news_per_page'), $total);

		$news_list = News::all([
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 'created_at desc',
			'include' => ['user'],
		]);

		App::view('news.index', compact('news_list', 'page'));
	}

	/**
	 * Просмотр новости
	 */
	public function view($id)
	{
		if (!$news = News::find_by_id($id)) App::abort('default', 'Новость не найдена');

		App::view('news.view', compact('news'));
	}

	/**
	 * Создание новости
	 */
	public function create()
	{
		if (!User::isAdmin()) App::abort('403');

		if (Request::isMethod('post')) {

			$news = new News;
			$news->category_id = Request::input('category_id');
			$news->user_id = User::get('id');
			$news->title = Request::input('title');
			$news->text = Request::input('text');

			//$news->image = Request::input('company_name');

			if ($news->save()) {
				App::setFlash('success', 'Новость успешно создана!');
				App::redirect('/news/'.$news->id);
			} else {
				App::setFlash('danger', $news->getErrors());
				App::setInput($_POST);
			}
		}

		$categories = Category::getAll();
		App::view('news.create', compact('categories'));
	}

	/**
	 * Создание комментария
	 */
	public function createComment($id)
	{
		if (! $news = News::find_by_id($id)) App::abort('default', 'Данной новости не существует!');

		$comment = new Comment();
		$comment->token = Request::input('token', true);
		$comment->user_id = User::get('id');
		$comment->relate_type = 'News';
		$comment->relate_id = $id;
		$comment->text = Request::input('text');
		$comment->ip = App::getClientIp();
		$comment->brow = App::getUserAgent();

		if ($comment->save()) {

			App::setFlash('success', 'Сообщение успешно добавлено!');
		} else {
			App::setFlash('danger', $comment->getErrors());
			App::setInput($_POST);
		}

		App::redirect('/news/'.$id);
	}

	/**
	 * RSS лента
	 */
	public function rss()
	{
		$news_list = News::all([
			'limit' => 15,
			'order' => 'created_at desc',
			'include' => ['user'],
		]);

		header("Content-type:application/rss+xml; charset=utf-8");
		App::view('news.rss', compact('news_list'));
	}
}
