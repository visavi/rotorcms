<form action="bookmark.php?act=del&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>" method="post">

	<?php foreach ($bookmarks as $bookmark): ?>

		<h5>
			<span class="glyphicon <?= $bookmark->topic()->getIcon() ?>"></span>
			<a href="topic.php?tid=<?= $bookmark->topic()->id ?>"><?= $bookmark->topic()->title ?></a> (<?= $bookmark->topic()->postCount() ?>)
		</h5>
		<div>
			Страницы: <?= forum_navigation('topic.php?tid='.$bookmark->topic()->id.'&amp;', $config['forumpost'], $bookmark->topic()->postCount())?>
			Сообщение: <?= $bookmark->topic()->user()->getLogin() ?> (<?= $bookmark->topic()->created_at ?>)
		</div>

		<div class="b">
			<input type="checkbox" name="del[]" value="<?= $topic->id ?>" />

			<?php $newpost = ($data['topics_posts'] > $data['book_posts']) ? '/<span style="color:#00cc00">+'.($data['topics_posts'] - $data['book_posts']).'</span>' : ''; ?>

			<b><a href="topic.php?tid=<?=$data['topics_id']?>"><?=$data['topics_title']?></a></b> (<?=$data['topics_posts']?><?=$newpost?>)
		</div>

		<div>
			Страницы:
			<?php forum_navigation('topic.php?tid='.$data['topics_id'].'&amp;', $config['forumpost'], $data['topics_posts']); ?>
			Автор: <?=nickname($data['topics_author'])?> / Посл.: <?=nickname($data['topics_last_user'])?> (<?=date_fixed($data['topics_last_time'])?>)
		</div>
	<?php endforeach; ?>

	<br />
	<input type="submit" value="Удалить выбранное" />
</form>
