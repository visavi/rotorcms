<?php

$link = $current_router['params']['link'];
$links = array('guestbook' => 'Гостевая', 'forum' => 'Форум', 'news' => 'Новости');
$link = array($link => $links[$link]);

$page = !empty($current_router['params']['page']) ? intval($current_router['params']['page']) : 1;

$total = Smile::count();

if ($total > 0 && ($page * $config['smilelist']) >= $total) {
	$page = ceil($total / $config['smilelist']);
}

$config['newtitle'] = 'Список смайлов (Стр. '.$page.')';
$offset = intval(($page * $config['smilelist']) - $config['smilelist']);

$smiles = Smile::all(array(
	'offset' => $offset,
	'limit' => $config['smilelist'],
	'order' => 'LENGTH(code)',
));

App::render('pages/smiles', compact('smiles', 'page', 'total', 'link'));
