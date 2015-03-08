<?php

$link = $current_router['params']['link'];
$links = array('guestbook' => 'Гостевая', 'forum' => 'Форум', 'news' => 'Новости');

show_title('Справка по BB-тегам');

App::render('pages/tags', array('link' => array($link => $links[$link])));
App::render('includes/back', array('link' => '/', 'title' => 'На главную'));
