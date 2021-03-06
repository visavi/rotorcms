<?php

Class ForumController Extends BaseController {

	/**
	 * Список форумов
	 */
	public function index()
	{
		$forums = Forum::all([
			'conditions' => ['parent_id = ?', 0],
			'order' => 'sort',
			'include' => [
				'topic_count',
				'children' => ['post_count', 'topic_count'],
				'topic_last' => ['post_last' => ['user']],
			],
		]);

		App::view('forums.index', compact('forums'));
	}

	/**
	 * Список тем
	 */
	public function forum($id)
	{
		if (! $forum = Forum::find_by_id($id)) App::abort('default', 'Данного раздела не существует!');

		$total = Topic::count(['conditions' => ['forum_id = ?', $id]]);
		$page = App::paginate(Setting::get('topics_per_page'), $total);

		$topics = Topic::all([
			'conditions' => ['forum_id = ?', $id],
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 'updated_at desc',
			'include' => [
				'forum',
				'post_count',
				'post_last' => ['user'],
			],
		]);

/*		$topics = Topic::all([
			'select' => 't.*, p.user_id post_user, p.created_at post_created',
			'from' => 'topics as t',
			'conditions' => ['t.forum_id = ?', $id],
			'joins' => ['LEFT JOIN (
					SELECT topic_id, MAX(created_at) AS max FROM posts
					GROUP BY topic_id
				) AS latest ON t.id = latest.topic_id
				LEFT JOIN posts p ON p.created_at = latest.max
				AND p.topic_id = latest.topic_id'],
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 't.updated_at desc',
			'include' => [
				'forum',
				'post_count',
			],*/

		$crumbs = ['/forum' => 'Форум', $forum->title];
		if ($forum->parent_id) {
			$crumbs = ['/forum' => 'Форум', '/forum/'.$forum->parent_id => $forum->parent()->title, $forum->title];
		}

		App::view('forums.forum', compact('forum', 'topics', 'page', 'crumbs'));
	}

	/**
	 * Список сообщений
	 */
	public function topic($id)
	{
		if (! $topic = Topic::find_by_id($id)) App::abort('default', 'Данной темы не существует!');

		if (User::check()) {
			$bookmark = Bookmark::find_by_topic_id_and_user_id($id, User::get('id'));

			if ($bookmark && $topic->postCount() > $bookmark->posts) {

				$bookmark->posts = $topic->postCount();
				$bookmark->save();
			}
		}

		$total = Post::count(['conditions' => ['topic_id = ?', $id]]);
		$page = App::paginate(Setting::get('posts_per_page'), $total);

		$posts = Post::all([
			'conditions' => ['topic_id = ?', $id],
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 'created_at',
			'include' => ['user'],
		]);

		$crumbs = ['/forum' => 'Форум', '/forum/'.$topic->forum()->id => $topic->forum()->title, $topic->title];
		if ($topic->forum()->parent_id) {
			$crumbs = ['/forum' => 'Форум', '/forum/'.$topic->forum()->parent_id => $topic->forum()->parent()->title, '/forum/'.$topic->forum()->id => $topic->forum()->title, $topic->title];
		}

		App::view('forums.topic', compact('topic', 'posts', 'page', 'crumbs'));
	}

	/**
	 * Редактирование сообщения
	 */
	public function editPost($id)
	{
		if (! $post = Post::find_by_id_and_user_id($id, User::get('id'))) App::abort('default', 'Сообщение не найдено');

		if ($post->created_at < Carbon::now()->subMinutes(10)) {
			App::abort('default', 'Редактирование невозможно, прошло более 10 мин.');
		}

		if (Request::isMethod('post')) {

			$post->token = Request::input('token', true);
			$post->text = Request::input('text');

			if ($post->save()) {
				App::setFlash('success', 'Сообщение успешно изменено!');
				App::redirect('/topic/'.$post->topic()->id);
			} else {
				App::setFlash('danger', $post->getErrors());
				App::setInput($_POST);
			}
		}

		App::view('forums.edit_post', compact('post'));
	}

	/**
	 * Создание темы
	 */
	public function createTopic()
	{
		if (Request::isMethod('post')) {

			$connection = Topic::connection();
			$connection->transaction();

			$topic = new Topic;
			$topic->token = Request::input('token', true);
			$topic->forum_id = Request::input('forum_id');
			$topic->title = Request::input('title');
			$topic->user_id = User::get('id');
			$topicSave = $topic->save();

			$post = new Post;
			$post->token = Request::input('token', true);
			$post->forum_id = Request::input('forum_id');
			$post->topic_id = $topic->id;
			$post->user_id = User::get('id');
			$post->text = Request::input('text');
			$post->ip = App::getClientIp();
			$post->brow = App::getUserAgent();

			if ($topicSave && $post->save()) {

				$post->topic->update_attribute('post_last_id', $post->id);
				$post->topic->forum->update_attribute('topic_last_id', $topic->id);

				$connection->commit();

				App::setFlash('success', 'Тема успешно создана!');
				App::redirect('/topic/'.$topic->id);
			} else {
				$connection->rollback();
				App::setFlash('danger', array_merge($post->getErrors(), $topic->getErrors()));
				App::setInput($_POST);
			}
		}

		$forums = Forum::getAll();

		App::view('forums.create', compact('forums'));
	}

	/**
	 * Создание сообщения
	 */
	public function createPost($id)
	{
		if (! $topic = Topic::find_by_id($id)) App::abort('default', 'Данной темы не существует!');

		$post = new Post();
		$post->token = Request::input('token', true);
		$post->forum_id = $topic->forum()->id;
		$post->topic_id = $topic->id;
		$post->user_id = User::get('id');
		$post->text = Request::input('text');
		$post->ip = App::getClientIp();
		$post->brow = App::getUserAgent();

		if ($post->save()) {

			$post->topic->update_attribute('post_last_id', $post->id);
			$post->topic->forum->update_attribute('topic_last_id', $topic->id);

			App::setFlash('success', 'Сообщение успешно добавлено!');
		} else {
			App::setFlash('danger', $post->getErrors());
			App::setInput($_POST);
		}

		/* Последняя страница в теме */
		$page = ceil($topic->postCount() / Setting::get('posts_per_page'));

		App::redirect('/topic/'.$id.'?page='.$page);
	}

	/**
	 * Добавление в закладки
	 */
	public function bookmark()
	{
		if (! Request::ajax()) App::redirect('/');

		$token = Request::input('token', true);
		$topic_id = Request::input('id');

		if (User::check() && $token == $_SESSION['token']) {

			/* Проверка темы на существование */
			if ($topic = Topic::find_by_id($topic_id)) {

				/* Добавление темы в закладки */
				if ($bookmark = Bookmark::find_by_topic_id_and_user_id($topic_id, User::get('id'))) {

					if ($bookmark->delete())
						exit(json_encode(['status' => 'deleted']));

				} else {
					$bookmark = new Bookmark;
					$bookmark->topic_id = $topic->id;
					$bookmark->user_id = User::get('id');
					$bookmark->posts = $topic->postCount();

					if ($bookmark->save())
						exit(json_encode(['status' => 'added']));
				}
			}
		}

		exit(json_encode(['status' => 'error']));
	}
}
