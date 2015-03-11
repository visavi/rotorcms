<?php

$router = new AltoRouter();

$router->addMatchTypes(array('s' => '[0-9A-Za-z-_]++'));

$router->map('GET', '/', 'index', 'home');

$router->map('GET', '/captcha', 'captcha', 'captcha');

$router->map('GET', '/guestbook', 'guestbook/index', 'guestbook');
$router->map('GET', '/guestbook/page/[i:page]', 'guestbook/index');
$router->map('GET', '/guestbook/[i:id]/[edit:action]', 'guestbook/index');
$router->map('POST', '/guestbook/[create|update:action]', 'guestbook/index');

$router->map('GET', '/forum', 'forum/index', 'forum');
$router->map('GET', '/forum/[i:fid]', 'forum/forum');

$router->map('GET', '/news', 'news/index', 'news');
$router->map('GET', '/news/page/[i:page]', 'news/index');
$router->map('GET', '/news/rss', array('page' => 'news/rss'), 'news_rss');

$router->map('GET', '/user/[i:id]/', 'users/user', 'profile_id');
$router->map('GET', '/user/[s:login]', 'users/user', 'profile_login');
$router->map('GET', '/users', 'users/users', 'users');
$router->map('GET', '/users/page/[i:page]', 'users/users');
$router->map('POST', '/users/[search:action]', 'users/users');

$router->map('GET', '/[guestbook|forum|news:link]/smiles/page/[i:page]', 'pages/smiles');
$router->map('GET', '/[guestbook|forum|news:link]/smiles', 'pages/smiles');
$router->map('GET', '/[guestbook|forum|news:link]/tags', 'pages/tags');

Registry::set('router', (object) $router->match());
