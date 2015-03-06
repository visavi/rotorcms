<?php

$router = new AltoRouter();

$router->map('GET','/', 'index.php', 'home');
$router->map('GET','/guestbook', 'guestbook/index.php', 'guestbook');
$router->map('GET','/rules', 'rules/index.php', 'rules');
$router->map('GET','/users/', array('c' => 'UserController', 'a' => 'ListAction'));
$router->map('GET','/users/[i:id]', 'users#show', 'users_show');
$router->map('POST','/users/[i:id]/[delete|update:action]', 'usersController#doAction', 'users_do');
