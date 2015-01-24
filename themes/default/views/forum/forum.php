<a href="index.php">Форум</a>

<?php if (!empty($forum->parent_id)): ?>
	/ <a href="forum.php?fid=<?= $forum->parent_id ?>"><?= $forum->parent()->title ?></a>
<?php endif; ?>

<?php if (empty($forum->closed)): ?>
	 <a class="btn btn-success" href="forum.php?act=addtheme&amp;fid=<?=$fid?>">Создать тему</a>
<?php endif; ?>

<?php if (is_admin()): ?>
	/ <a href="/admin/forum.php?act=forum&amp;fid=<?=$fid?>&amp;start=<?=$start?>">Управление</a>
<?php endif; ?>

<?php if ($forum->children && empty($start)): ?>
	<?php foreach ($forum->children as $subforum): ?>
		<div>
			<h4>
				<a class="touch-link" href="forum.php?fid=<?= $subforum->id ?>">
					<span class="glyphicon glyphicon-comment"></span>
					<?= $subforum->title ?>
					<span class="badge"><?= $subforum->topicCount() ?>/<?= $subforum->topicLast()->postCount() ?></span>
				</a>
			</h4>

			<?php if ($subforum->description): ?>
				<span class="help-block"><?= $subforum->description ?></span>
			<?php endif; ?>

			<?php if ($subforum->topic_last): ?>
				Тема: <a href="topic.php?act=end&amp;tid=<?= $subforum->topicLast()->id ?>"><?= $subforum->topicLast()->title ?></a><br />

				<?php if ($subforum->topicLast()->postLast()->user()->id): ?>
					Сообщение: <?= $subforum->topicLast()->postLast()->user()->getLogin() ?> (<?= $subforum->topicLast()->postLast()->created_at ?>)
				<?php endif; ?>

			<?php else: ?>
				Темы еще не созданы!
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<?php if ($forum->topics): ?>
	<?php foreach ($forum->topics as $topic): ?>
		<h5 id="topic_<?= $topic->id ?>">

			<a class="touch-link" href="topic.php?tid=<?= $topic->id ?>">
				<span class="glyphicon <?= $topic->getIcon() ?>"></span>
				<?= $topic->title ?>
				<span class="badge"><?= $topic->postCount() ?></span>
			</a>
		</h5>
		<div>
			Страницы: <?= forum_navigation('topic.php?tid='.$topic->id.'&amp;', $config['forumpost'], $topic->postCount())?>

			<?php if ($topic->postLast()->user()->id): ?>
				Сообщение: <?= $topic->postLast()->user()->getLogin() ?> (<?= $topic->postLast()->created_at ?>)
			<?php endif; ?>

		</div>
	<?php endforeach; ?>

	<?php page_strnavigation('forum.php?fid='.$fid.'&amp;', $config['forumtem'], $start, $total); ?>

<?php elseif ($forum->closed): ?>
	<?=show_error('В данном разделе запрещено создавать темы!')?>
<?php else: ?>
	<?=show_error('Тем еще нет, будь первым!')?>
<?php endif; ?>


<a href="forum.php?act=addtheme&amp;fid=<?=$fid?>">Создать тему</a> /
<a href="/pages/rules.php">Правила</a> /
<a href="top.php?act=themes">Топ тем</a> /
<a href="search.php?fid=<?=$fid?>">Поиск</a><br />

