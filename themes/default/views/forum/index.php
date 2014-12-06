<?php if ($forums): ?>
	<?php if (is_user()): ?>
		Мои: <a href="active.php?act=themes">темы</a>, <a href="active.php?act=posts">сообщения</a>, <a href="bookmark.php">закладки</a> /
	<?php endif; ?>

	Новые: <a href="new.php?act=themes">темы</a>, <a href="new.php?act=posts">сообщения</a><hr />

	<?php foreach($forums as $forum): ?>
		<div class="media">
			<h4>
				<span class="glyphicon glyphicon-comment"></span>
				<a href="forum.php?fid=<?= $forum->id ?>"><?= $forum->title ?></a>
				(<?= $forum->topicCount() ?>/<?= $forum->topicLast()->postCount() ?>)
			</h4>

		<?php if ($forum->description): ?>
			<span class="help-block"><?= $forum->description ?></span>
		<?php endif; ?>


		<?php if ($forum->children): ?>
			<?php foreach($forum->children as $subforum): ?>
				<h5>
					<span class="glyphicon glyphicon-folder-open"></span> <a href="forum.php?fid=<?= $subforum->id?>"><?= $subforum->title ?></a> (<?= $subforum->topicCount() ?>/<?= $subforum->topicLast()->postCount() ?>)
				</h5>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ($forum->topic_last): ?>
			Тема: <a href="topic.php?act=end&amp;tid=<?= $forum->topicLast()->id ?>"><?= $forum->topicLast()->title ?></a><br />
			<?php if ($forum->topicLast()->postLast()->user()->id): ?>
				Сообщение: <?= $forum->topicLast()->postLast()->user()->getLogin() ?> (<?= $forum->topicLast()->postLast()->created_at ?>)
			<?php endif; ?>
		<?php else: ?>
			Темы еще не созданы!
		<?php endif; ?>

		</div>
	<?php endforeach; ?>

<?php else: ?>
	<?= show_error('Разделы форума еще не созданы!') ?>
<?php endif; ?>

<a href="/pages/rules.php">Правила</a> / <a href="top.php?act=themes">Топ тем</a> / <a href="search.php">Поиск</a><br />
