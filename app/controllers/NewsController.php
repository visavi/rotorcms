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
	public function view($category, $slug)
	{
		$id = current(explode('-', $slug));
		if (! $category = Category::find_by_slug($category)) App::abort('default', 'Категория не найдена');
		if (! $news = News::find_by_id($id)) App::abort('default', 'Новость не найдена');

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
			$news->slug = '';
			$news->text = Request::input('text');

			$image = Request::file('image');
			if ($image && $image->isValid()) {

				$ext = $image->getClientOriginalExtension();
				$filename = uniqid(mt_rand()).'.'.$ext;

				if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])) {
					$img = new SimpleImage($image->getPathName());
					$img->best_fit(1280, 1280)->save('uploads/news/images/'.$filename);
					$img->best_fit(200, 200)->save('uploads/news/thumbs/'.$filename);
				}
				$news->image = $filename;
			}

			if ($news->save()) {

				if ($tags = Request::input('tags')) {
					$tags = array_map('trim', explode(',', $tags));

					foreach ($tags as $tag) {
						$tag = Tag::create(['name' => $tag]);
						$tag->create_news_tags(['news_id' => $news->id]);
					}
				}

				App::setFlash('success', 'Новость успешно создана!');
				App::redirect('/'.$news->category->slug.'/'.$news->slug);
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
		$comment->relate_id = $news->id;
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

	/**
	 * Теги
	 */
	public function tags()
	{
		$query = Request::input('query');

		$tags = Tag::all([
			'conditions' => ['`name` LIKE ?', '%'.$query.'%'],
			'select' => 'count(*) as cnt, name',
			'group' => 'name',
			'order' => 'cnt DESC',
			'limit' => 10
		]);

		$sortTags = [];
		foreach ($tags as $tag) {
			//$sortTags[] = ['name' => $tag->name, 'count' => $tag->cnt];
			$sortTags[] = $tag->name;
		}

		exit(json_encode($sortTags));
	}
}
