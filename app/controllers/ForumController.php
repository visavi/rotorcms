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
		$page = Request::input('page', 1);

		if (Forum::exists($id)) {
			$total = Topic::count(array('conditions' => array('forum_id = ?', $id)));
			$topics = Topic::all(array('conditions' => array('forum_id = ?', $id), 'include' => 'forum'));

			//$config['header'] = $forum->title;
			//$config['newtitle'] = $forum->title.' (Стр. '.$page.')';

/*			if (!empty($forums['forums_parent'])) {
				$forums['subparent'] = DB::run() -> queryFetch("SELECT `forums_id`, `forums_title` FROM `forums` WHERE `forums_id`=? LIMIT 1;", array($forums['forums_parent']));
			}*/

			//$querysub = DB::run() -> query("SELECT * FROM `forums` WHERE `forums_parent`=? ORDER BY `forums_order` ASC;", array($fid));
			//$forums['subforums'] = $querysub -> fetchAll();

			//$total = DB::run() -> querySingle("SELECT count(*) FROM `topics` WHERE `topics_forums_id`=?;", array($fid));

			if ($total > 0 && $start >= $total) {
				$start = last_page($total, $config['forumtem']);
			}

			//$querytopic = DB::run() -> query("SELECT * FROM `topics` WHERE `topics_forums_id`=? ORDER BY `topics_locked` DESC, `topics_last_time` DESC LIMIT ".$start.", ".$config['forumtem'].";", array($fid));
			//$forums['topics'] = $querytopic->fetchAll();

			App::view('forums.topic', compact('topics', 'page', 'total'));

		} else {
			App::abort('default', 'Данного раздела не существует!');
		}

	}
}
