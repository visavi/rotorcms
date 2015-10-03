<?php

$router = new AltoRouter();

$router->addMatchTypes(array('s' => '[0-9A-Za-z-_]++'));

$router->map('GET', '/', 'HomeController@index', 'home');
$router->map('GET', '/captcha', 'HomeController@captcha', 'captcha');
$router->map('POST', '/complaint', 'HomeController@complaint', 'complaint');

$router->map('GET|POST', '/register', 'UserController@register', 'register');
$router->map('GET|POST', '/login', 'UserController@login', 'login');
$router->map('GET|POST', '/recovery', 'UserController@recovery', 'recovery');
$router->map('GET|POST', '/reset', 'UserController@reset', 'reset');
$router->map('GET|POST', '/user/[edit|password:action]', 'UserController');
$router->map('GET|POST', '/users', 'UserController@index');
$router->map('GET', '/logout', 'UserController@logout', 'logout');
$router->map('GET', '/user/[s:login]', 'UserController@view', 'profile');
$router->map('POST', '/user/image', 'UserController@image');

$router->map('GET', '/guestbook', 'GuestbookController@index', 'guestbook');
$router->map('POST', '/guestbook/create', 'GuestbookController@create');
$router->map('GET|POST', '/guestbook/[i:id]/edit', 'GuestbookController@edit');

$router->map('GET', '/forum', 'ForumController@index', 'forum');
$router->map('GET', '/forum/[i:id]', 'ForumController@forum');
$router->map('GET', '/topic/[i:id]', 'ForumController@topic');
$router->map('POST', '/topic/bookmark', 'ForumController@bookmark');
$router->map('POST', '/topic/[i:id]/create', 'ForumController@createPost');
$router->map('GET|POST', '/forum/create', 'ForumController@createTopic');
$router->map('GET|POST', '/post/[i:id]/edit', 'ForumController@editPost');

$router->map('GET', '/news', 'NewsController@index', 'news');
$router->map('GET', '/news/[i:id]', 'NewsController@view', 'news_view');
$router->map('GET|POST', '/news/create', 'NewsController@create');
$router->map('GET', '/news/rss', 'NewsController@rss', 'news_rss');

$router->map('GET', '/admin', 'AdminController@index', 'admin');

$router->map('GET', '/[guestbook|forum|news:link]/smiles/page/[i:page]', 'pages/smiles');
$router->map('GET', '/[guestbook|forum|news:link]/smiles', 'pages/smiles');
$router->map('GET', '/[guestbook|forum|news:link]/tags', 'pages/tags');

Registry::set('router', $router->match());
