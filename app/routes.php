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
$router->map('GET', '/logout', 'UserController@logout', 'logout');

$router->map('GET', '/user/[s:login]', 'UserController@view', 'profile');
$router->map('GET', '/users', 'users/users', 'users');
$router->map('GET', '/users/page/[i:page]', 'users/users');
$router->map('POST', '/users/[search:action]', 'users/users');

$router->map('GET', '/guestbook', 'GuestbookController@index', 'guestbook');
$router->map('POST', '/guestbook/[create|update:action]', 'GuestbookController');
$router->map('GET', '/guestbook/[i:id]/[edit:action]', 'GuestbookController');

$router->map('GET', '/forum', 'forum/index', 'forum');
$router->map('GET', '/forum/[i:fid]', 'forum/forum');

$router->map('GET', '/news', 'news/index', 'news');
$router->map('GET', '/news/page/[i:page]', 'news/index');
$router->map('GET', '/news/rss', array('page' => 'news/rss'), 'news_rss');


$router->map('GET', '/[guestbook|forum|news:link]/smiles/page/[i:page]', 'pages/smiles');
$router->map('GET', '/[guestbook|forum|news:link]/smiles', 'pages/smiles');
$router->map('GET', '/[guestbook|forum|news:link]/tags', 'pages/tags');

Registry::set('router', $router->match());
