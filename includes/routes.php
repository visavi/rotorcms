<?php

$router = new AltoRouter();

$router->addMatchTypes(array('s' => '[0-9A-Za-z-_]++'));

$router->map('GET', '/', 'index.php', 'home');

$router->map('GET', '/captcha', array('page' => 'captcha.php'), 'captcha');

$router->map('GET', '/guestbook', 'guestbook/index.php', 'guestbook');
$router->map('GET', '/guestbook/page/[i:page]', 'guestbook/index.php');
$router->map('GET', '/guestbook/[i:id]/[edit:action]', 'guestbook/index.php');
$router->map('POST', '/guestbook/[create|update:action]', 'guestbook/index.php');

$router->map('GET', '/forum', 'forum/index.php', 'forum');
$router->map('GET', '/forum/[i:fid]', 'forum/forum.php');

$router->map('GET', '/news', 'news/index.php', 'news');
$router->map('GET', '/news/page/[i:page]', 'news/index.php');
$router->map('GET', '/news/rss', array('page' => 'news/rss.php'), 'news_rss');

$router->map('GET', '/user/[i:id]/', 'users/user.php', 'profile_id');
$router->map('GET', '/user/[s:login]', 'users/user.php', 'profile_login');
$router->map('GET', '/users', 'users/users.php', 'users');
$router->map('GET', '/users/page/[i:page]', 'users/users.php');
$router->map('POST', '/users/[search:action]', 'users/users.php');

$router->map('GET', '/[guestbook|forum|news:link]/smiles/page/[i:page]', 'pages/smiles.php');
$router->map('GET', '/[guestbook|forum|news:link]/smiles', 'pages/smiles.php');
$router->map('GET', '/[guestbook|forum|news:link]/tags', 'pages/tags.php');

if (!$current_router = $router->match()) {
	header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
}
