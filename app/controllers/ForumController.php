<?php

Class ForumController Extends BaseController {

	/**
	 * Список форумов
	 */
	public function index()
	{
		$forums = Forum::all(array(
			'conditions' => array('parent_id = ?', 0),
			'order' => 'sort',
			'include' => array('children', 'topic_last', 'topic_count'),
		));

		App::view('forums.index', compact('forums'));
	}

	/**
	 * Список тем
	 */
	public function forum($id)
	{
		if (!$forum = Forum::find_by_id($id)) App::abort('default', 'Данного раздела не существует!');

		$total = Topic::count(['conditions' => ['forum_id = ?', $id]]);
		$page = getPage(Setting::get('topics_per_page'), $total);


		$topics = Topic::all([
			'conditions' => ['forum_id = ?', $id],
			'offset' => $page['offset'],
			'limit' => $page['limit'],
			'order' => 'updated_at desc',
			'include' => ['forum', 'user'],
		]);

		App::view('forums.forum', compact('forum', 'topics', 'page'));
	}
}
