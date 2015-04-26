<form action="bookmark.php?act=del&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>" method="post">

	<?php foreach ($bookmarks as $bookmark): ?>

		<?php $newpost = ($bookmark->topic()->postCount() > $bookmark->posts) ? '/<span style="color:#00cc00">+'.($bookmark->topic()->postCount() - $bookmark->posts).'</span>' : ''; ?>

		<div>
		<div class="pull-right">
			<input type="checkbox" name="del[]" value="<?= $bookmark->id ?>" />
		</div>
		<h5>
			<span class="glyphicon <?= $bookmark->topic()->getIcon() ?>"></span>
			<a href="topic.php?tid=<?= $bookmark->topic()->id ?>"><?= $bookmark->topic()->title ?></a> (<?= $bookmark->topic()->postCount() ?><?=$newpost?>)
		</h5>
		</div>

		<div>
			Страницы: <?= forum_navigation('topic.php?tid='.$bookmark->topic()->id.'&amp;', $config['forumpost'], $bookmark->topic()->postCount())?>
			Автор: <?= $bookmark->topic()->user()->getLogin() ?> / Посл.: <?= $bookmark->topic()->postLast()->user()->getLogin() ?> (<?= $bookmark->topic()->created_at ?>)
		</div>

	<?php endforeach; ?>
	<button type="submit" class="btn btn-default btn-xs pull-right">Удалить выбранное</button>
</form>

<?php page_strnavigation('bookmark.php?', $config['forumtem'], $start, $total);  ?>

