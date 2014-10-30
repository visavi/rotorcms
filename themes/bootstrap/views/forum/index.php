<?php if (is_user()): ?>
	Мои: <a href="active.php?act=themes">темы</a>, <a href="active.php?act=posts">сообщения</a>, <a href="bookmark.php">закладки</a> /
<?php endif; ?>

Новые: <a href="new.php?act=themes">темы</a>, <a href="new.php?act=posts">сообщения</a><hr />

<?php foreach($forums as $forum): ?>
	<div class="b">
		<img src="/images/img/forums.gif" alt="image" />
		<b><a href="forum.php?fid=<?= $forum->id ?>"><?= $forum->title ?></a></b> (<?= $forum->topicCount() ?>/<?= $forum->topic()->postCount() ?>)

	<?php if (!empty($forum->desc)): ?>
		<br /><small><?= $forum->desc ?></small>
	<?php endif; ?>

	</div>

	<div>
	<?php if ($forum->parents): ?>
		<?php foreach($forum->parents as $subforum): ?>
			<img src="/images/img/topics-small.gif" alt="image" /> <b><a href="forum.php?fid=<?= $subforum->id?>"><?= $subforum->title ?></a></b> (<?= $subforum->topicCount() ?>/<?= $subforum->topic()->postCount() ?>)<br />
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ($forum->topic): ?>
		Тема: <a href="topic.php?act=end&amp;tid=<?= $forum->topic->id ?>"><?= $forum->topic->title ?></a><br />
		Сообщение: <?= $forum->topic()->user()->getLogin() ?> (<?= $forum->topic()->created_at ?>)
	<?php else: ?>
		Темы еще не созданы!
	<?php endif; ?>

	</div>
<?php endforeach; ?>

<br /><a href="/pages/rules.php">Правила</a> / <a href="top.php?act=themes">Топ тем</a> / <a href="search.php">Поиск</a><br />
