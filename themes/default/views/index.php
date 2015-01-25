<?php $config['newtitle'] = 'Главная страница'; ?>

<a href="/news" class="index touch-link"><span class="fa fa-circle"></span> Новости сайта <span class="badge"><?=stats_news()?></span></a>
<?=last_news()?>

<a href="/pages/index.php?act=recent" class="index touch-link"><span class="fa fa-circle"></span> Общение</a>
<a href="/book" class="index touch-link"><span class="fa fa-circle"></span> Гостевая книга <span class="badge"><?=stats_guest()?></span></a>
<a href="/gallery" class="index touch-link"><span class="fa fa-circle"></span> Фотогалерея <span class="badge"><?=stats_gallery()?></span></a>

<a href="/forum" class="index touch-link"><span class="fa fa-circle"></span> Форум <span class="badge"><?=stats_forum()?></span></a>
<?=recenttopics()?>

<a href="/load" class="index touch-link"><span class="fa fa-circle"></span> Загрузки <span class="badge"><?=stats_load()?></span></a>
<?=recentfiles()?>

<a href="/blog" class="index touch-link"><span class="fa fa-circle"></span> Блоги <span class="badge"><?=stats_blog()?></span></a>
<?=recentblogs()?>

<a href="/pages/index.php" class="index touch-link"><span class="fa fa-circle"></span> Сервисы сайта</a>
<a href="/mail" class="index touch-link"><span class="fa fa-circle"></span> Обратная связь</a>
<a href="/pages/userlist.php" class="index touch-link"><span class="fa fa-circle"></span> Список юзеров <span class="badge"><?=stats_users()?></span></a>
<a href="/pages/index.php?act=stat" class="index touch-link"><span class="fa fa-circle"></span> Информация</a>
<a href="/pages/index.php?act=partners" class="index touch-link"><span class="fa fa-circle"></span> Партнеры и друзья</a>

