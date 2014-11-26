<?php $config['newtitle'] = 'Главная страница'; ?>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/news"><span class="fa fa-circle-o"></span> Новости сайта (<?=stats_news()?>)</a></li> <?=last_news()?></li>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/pages/index.php?act=recent"><span class="fa fa-circle-o"></span> Общение</a></li>
	<li class="index-link"><a href="/book"><span class="fa fa-circle-o"></span> Гостевая книга (<?=stats_guest()?>)</a></li>
	<li class="index-link"><a href="/gallery"><span class="fa fa-circle-o"></span> Фотогалерея (<?=stats_gallery()?>)</a></li>

	<li class="index-link"><a href="/forum"><span class="fa fa-circle-o"></span> Форум (<?=stats_forum()?>)</a></li>
</ul>

<ul class="nav nav-pills nav-stacked">
	<?=recenttopics()?>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/load"><span class="fa fa-circle-o"></span> Загрузки (<?=stats_load()?>)</a></li>
	<?=recentfiles()?>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/blog"><span class="fa fa-circle-o"></span> Блоги (<?=stats_blog()?>)</a></li>
	<?=recentblogs()?>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/pages/index.php"><span class="fa fa-circle-o"></span> Сервисы сайта</a></li>
	<li class="index-link"><a href="/mail"><span class="fa fa-circle-o"></span> Обратная связь</a></li>
	<li class="index-link"><a href="/pages/userlist.php"><span class="fa fa-circle-o"></span> Список юзеров (<?=stats_users()?>)</a></li>
	<li class="index-link"><a href="/pages/adminlist.php"><span class="fa fa-circle-o"></span> Администрация (<?=stats_admins()?>)</a></li>
	<li class="index-link"><a href="/pages/index.php?act=stat"><span class="fa fa-circle-o"></span> Информация</a></li>
	<li class="index-link"><a href="/pages/index.php?act=partners"><span class="fa fa-circle-o"></span> Партнеры и друзья</a></li>
</ul>
