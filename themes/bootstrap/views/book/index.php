<ul class="breadcrumb">
	<li><a href="/pages/rules.php">Правила</a></li>
	<li><a href="/pages/smiles.php">Смайлы</a></li>
	<li><a href="/pages/tags.php">Теги</a></li>

	<?php if (is_admin()):?>
		<li><a href="/admin/book.php?start=<?= $start ?>">Управление</a></li>
	<?php endif;?>
</ul>



<?php if ($total > 0): ?>
	<?php foreach ($posts as $post): ?>

<?php
//var_dump($post);
$date = new DateTime();
var_dump($date);
echo date('Y-m-d H:i:s', $date->getTimestamp());

?>
		<div class="media" id="post">

			<?= user_avatars($post->user_login) ?>

			<div class="media-body">
				<ul class="list-inline pull-right small">

				<?php if ($user && $user->id != $post->user_id): ?>

					<li><a href="#" onclick="return reply('<?= $post->user_login ?>')">Отв</a></li>

					<li><noindex><a href="index.php?act=spam&amp;id=<?= $post->id ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>" onclick="return confirm('Вы подтверждаете факт спама?')" rel="nofollow">Спам</a></noindex></li>
				<?php endif; ?>
<?php
var_dump(date('Y-m-d H:i:s',strtotime($post->created_at->format('Y-m-d H:i:s'))), date('Y-m-d H:i:s', $post->created_at->getTimestamp()));
?>
				<?php if ($user->id == $post->user_id && $post->created_at->getTimestamp() > time() - 600): ?>
					<li><a href="index.php?act=edit&amp;id=<?= $post->id ?>&amp;start=<?= $start ?>">Редактировать</a></li>
				<?php endif; ?>

					<li><?= $post->created_at ?></li>
				</ul>
				<h4 class="media-heading"><?= profile($post->user_login) ?></h4>
				<span class="message"><?= bb_code($post->text) ?></span>
			</div>
		</div>









		<div id="post">
		<div class="b">
			<div class="img"><?= user_avatars($post->user_login) ?></div>
			<?php if ($post->user_login == $config['guestsuser']): ?>
				<b><?= $post->user_login ?></b> <small>(<?= $post->created_at ?>)</small>
			<?php else: ?>
				<b><?= profile($post->user_login) ?></b> <small>(<?= $post->created_at ?>)</small><br />
				<?= user_title($post->user_login) ?> <?= user_online($post->user_login) ?>
			<?php endif; ?>
		</div>



		<div>
			<span class="message"><?= bb_code($post->text) ?></span><br />

			<?php if (!empty($post->edit_user_id)): ?>
				<img src="/images/img/exclamation_small.gif" alt="image" /> <small>Отредактировано: <?= $post->user_login ?> (<?= $post->updated_at->format('long') ?>)</small><br />
			<?php endif; ?>

			<?php if (is_admin() || empty($config['anonymity'])): ?>
				<span class="data">(<?= $post->brow ?>, <?= $post->ip ?>)</span>
			<?php endif; ?>

			<?php if (!empty($post->reply)): ?>
				<br /><span style="color:#ff0000">Ответ: <?= $post->reply ?></span>
			<?php endif; ?>

		</div>
		</div>
	<?php endforeach; ?>

	<?php page_strnavigation('index.php?', $config['bookpost'], $start, $total); ?>

<?php else: ?>
	<?php show_error('Сообщений нет, будь первым!'); ?>
<?php endif; ?>


<?php if (is_user()): ?>
	<div class="well">
		<form action="index.php?act=add&amp;token=<?= $_SESSION['token'] ?>" method="post">

		<textarea class="form-control" id="markItUp" cols="25" rows="5" name="msg"></textarea><br />
		<input type="submit" value="Написать" /></form>
	</div><br />

<?php elseif ($config['bookadds'] == 1): ?>

	<div class="well">
		<form action="index.php?act=add&amp;token=<?= $_SESSION['token'] ?>" method="post">
		Сообщение:<br />
		<textarea class="form-control" cols="25" rows="5" name="msg"></textarea><br />

		Проверочный код:<br />
		<img src="/gallery/protect.php" alt="" /><br />
		<input name="provkod" size="6" maxlength="6" /><br />

		<input type="submit" value="Написать" /></form>
	</div><br />

<?php else: ?>
	<?php show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо'); ?>
<?php endif; ?>

