<?php

show_title('Форум '.$config['title']);
$config['newtitle'] = 'Форум - Список разделов';

include_once (DATADIR.'/advert/forum.dat');

$forums = Forum::all(array(
	'conditions' => array('parent_id = ?', 0),
	'order' => 'sort',
	'include' => array('children', 'topic_last', 'topic_count'),
));

App::render('forum/index', compact('forums'));
