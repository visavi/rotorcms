<?php $config['newtitle'] = 'Главная страница'; ?>

<a href="/news" class="index link"><span class="fa fa-circle-o"></span> Новости сайта <span class="badge"><?=stats_news()?></span></a>
<?=last_news()?>

<a href="/pages/index.php?act=recent" class="index link"><span class="fa fa-circle-o"></span> Общение</a>
<a href="/book" class="index link"><span class="fa fa-circle-o"></span> Гостевая книга <span class="badge"><?=stats_guest()?></span></a>
<a href="/gallery" class="index link"><span class="fa fa-circle-o"></span> Фотогалерея <span class="badge"><?=stats_gallery()?></span></a>

<a href="/forum" class="index link"><span class="fa fa-circle-o"></span> Форум <span class="badge"><?=stats_forum()?></span></a>
<?=recenttopics()?>

<a href="/load" class="index link"><span class="fa fa-circle-o"></span> Загрузки <span class="badge"><?=stats_load()?></span></a>
<?=recentfiles()?>

<a href="/blog" class="index link"><span class="fa fa-circle-o"></span> Блоги <span class="badge"><?=stats_blog()?></span></a>
<?=recentblogs()?>

<a href="/pages/index.php" class="index link"><span class="fa fa-circle-o"></span> Сервисы сайта</a>
<a href="/mail" class="index link"><span class="fa fa-circle-o"></span> Обратная связь</a>
<a href="/pages/userlist.php" class="index link"><span class="fa fa-circle-o"></span> Список юзеров <span class="badge"><?=stats_users()?></span></a>
<a href="/pages/adminlist.php" class="index link"><span class="fa fa-circle-o"></span> Администрация <span class="badge"><?=stats_admins()?></span></a>
<a href="/pages/index.php?act=stat" class="index link"><span class="fa fa-circle-o"></span> Информация</a>
<a href="/pages/index.php?act=partners" class="index link"><span class="fa fa-circle-o"></span> Партнеры и друзья</a>

