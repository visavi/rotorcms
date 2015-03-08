<?php

$router = new AltoRouter();

$router->map('GET', '/', 'index.php', 'home');

$router->map('GET', '/guestbook', 'guestbook/index.php', 'guestbook');
$router->map('POST', '/guestbook/[add|change:action]', 'guestbook/index.php', 'guestbook_add');
$router->map('GET', '/guestbook/page/[i:page]', 'guestbook/index.php');
$router->map('GET', '/guestbook/[i:id]/[edit:action]', 'guestbook/index.php');

$current_router = $router->match();
