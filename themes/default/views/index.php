<?php $config['newtitle'] = 'Главная страница'; ?>

<a href="/news" class="index touch-link"><span class="fa fa-circle"></span> Новости сайта <span class="badge"><?=stats_news()?></span></a>
<?=last_news()?>

<a href="/guestbook" class="index touch-link"><span class="fa fa-circle"></span> Гостевая книга <span class="badge"><?=stats_guest()?></span></a>

<a href="/forum" class="index touch-link"><span class="fa fa-circle"></span> Форум <span class="badge"><?=stats_forum()?></span></a>
<?=recenttopics()?>

<a href="/pages/userlist.php" class="index touch-link"><span class="fa fa-circle"></span> Список юзеров <span class="badge"><?=stats_users()?></span></a>
