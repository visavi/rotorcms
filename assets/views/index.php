<?php $config['newtitle'] = 'Главная страница'; ?>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/news"><span class="fa fa-circle-o"></span> Новости сайта</a> (<?=stats_news()?>)</li> <?=last_news()?></li>

	<li class="index-link"><a href="/pages/index.php?act=recent"><span class="fa fa-circle-o"></span> Общение</a></li>

	<li class="index-link"><a href="/book"><span class="fa fa-circle-o"></span> Гостевая книга</a> (<?=stats_guest()?>)</li>
	<li class="index-link"><a href="/gallery"><span class="fa fa-circle-o"></span> Фотогалерея</a> (<?=stats_gallery()?>)</li>

	<li class="index-link"><a href="/forum"><span class="fa fa-circle-o"></span> Форум</a> (<?=stats_forum()?>)</li>
	<?=recenttopics()?>

	<li class="index-link"><a href="/load"><span class="fa fa-circle-o"></span> Загрузки</a> (<?=stats_load()?>)</li>
	<?=recentfiles()?>

	<li class="index-link"><a href="/blog"><span class="fa fa-circle-o"></span> Блоги</a> (<?=stats_blog()?>)</li>
	<?=recentblogs()?>

	<li class="index-link"><a href="/pages/index.php"><span class="fa fa-circle-o"></span> Сервисы сайта</a></li>
	<li class="index-link"><a href="/mail"><span class="fa fa-circle-o"></span> Обратная связь</a></li>
	<li class="index-link"><a href="/pages/userlist.php"><span class="fa fa-circle-o"></span> Список юзеров</a> (<?=stats_users()?>)</li>
	<li class="index-link"><a href="/pages/adminlist.php"><span class="fa fa-circle-o"></span> Администрация</a> (<?=stats_admins()?>)</li>
	<li class="index-link"><a href="/pages/index.php?act=stat"><span class="fa fa-circle-o"></span> Информация</a></li>
	<li class="index-link"><a href="/pages/index.php?act=partners"><span class="fa fa-circle-o"></span> Партнеры и друзья</a></li>
</ul>