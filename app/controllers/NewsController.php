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
