<?php $config['newtitle'] = 'Главная страница'; ?>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link "><a href="/news"><span class="fa fa-circle-o"></span> Новости сайта <span class="badge"><?=stats_news()?></span></a></li> <?=last_news()?></li>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/pages/index.php?act=recent"><span class="fa fa-circle-o"></span> Общение</a></li>
	<li class="index-link"><a href="/book"><span class="fa fa-circle-o"></span> Гостевая книга <span class="badge"><?=stats_guest()?></span></a></li>
	<li class="index-link"><a href="/gallery"><span class="fa fa-circle-o"></span> Фотогалерея <span class="badge"><?=stats_gallery()?></span></a></li>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/forum"><span class="fa fa-circle-o"></span> Форум <span class="badge"><?=stats_forum()?></span></a></li>

	<?=recenttopics()?>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/load"><span class="fa fa-circle-o"></span> Загрузки <span class="badge"><?=stats_load()?></span></a></li>
	<?=recentfiles()?>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/blog"><span class="fa fa-circle-o"></span> Блоги <span class="badge"><?=stats_blog()?></span></a></li>
	<?=recentblogs()?>
</ul>

<ul class="nav nav-pills nav-stacked">
	<li class="index-link"><a href="/pages/index.php"><span class="fa fa-circle-o"></span> Сервисы сайта</a></li>
	<li class="index-link"><a href="/mail"><span class="fa fa-circle-o"></span> Обратная связь</a></li>
	<li class="index-link"><a href="/pages/userlist.php"><span class="fa fa-circle-o"></span> Список юзеров <span class="badge"><?=stats_users()?></span></a></li>
	<li class="index-link"><a href="/pages/adminlist.php"><span class="fa fa-circle-o"></span> Администрация <span class="badge"><?=stats_admins()?></span></a></li>
	<li class="index-link"><a href="/pages/index.php?act=stat"><span class="fa fa-circle-o"></span> Информация</a></li>
	<li class="index-link"><a href="/pages/index.php?act=partners"><span class="fa fa-circle-o"></span> Партнеры и друзья</a></li>
</ul>
