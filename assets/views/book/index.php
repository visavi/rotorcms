<a href="/pages/rules.php">Правила</a> /
<a href="/pages/smiles.php">Смайлы</a> /
<a href="/pages/tags.php">Теги</a>

<?php if (is_admin()):?>
	/ <a href="/admin/book.php?start=<?= $start ?>">Управление</a>
<?php endif;?>
<hr />


<?php if ($total > 0): ?>
	<?php foreach ($posts as $data): ?>

		<div class="b">
			<div class="img"><?= user_avatars($data->user->getLogin()) ?></div>

			<?php if ($data->user->getLogin() == $config['guestsuser']): ?>
				<b><?= $data->user->getLogin() ?></b> <small>(<?= date_fixed($data->time) ?>)</small>
			<?php else: ?>
				<b><?= profile($data->user->getLogin()) ?></b> <small>(<?= date_fixed($data->time) ?>)</small><br />
				<?= user_title($data->user->getLogin())?> <?= user_online($data->user->getLogin())?>
			<?php endif; ?>
		</div>

		<?php if (!empty($log) && $log != $data->user->getLogin()): ?>
			<div class="right">
			<a href="index.php?act=reply&amp;id=<?= $data->id ?>&amp;start=<?= $start ?>">Отв</a> /
			<a href="index.php?act=quote&amp;id=<?= $data->id ?>&amp;start=<?= $start ?>">Цит</a> /
			<noindex><a href="index.php?act=spam&amp;id=<?= $data->id ?>&amp;start=<?= $start ?>&amp;uid=<?= $_SESSION['token'] ?>" onclick="return confirm('Вы подтверждаете факт спама?')" rel="nofollow">Спам</a></noindex></div>
		<?php endif; ?>

		<?php if ($log == $data->user->getLogin() && $data->time + 600 > SITETIME): ?>
			<div class="right"><a href="index.php?act=edit&amp;id=<?= $data->id ?>&amp;start=<?= $start ?>">Редактировать</a></div>
		<?php endif; ?>

		<div>
			<?= bb_code($data->text) ?><br />

			<?php if (!empty($data->edit)): ?>
				<img src="/images/img/exclamation_small.gif" alt="image" /> <small>Отредактировано: <?= nickname($data->edit)?> (<?= date_fixed($data->edit_time) ?>)</small><br />
			<?php endif; ?>

			<?php if (is_admin() || empty($config['anonymity'])): ?>
				<span class="data">(<?= $data->brow ?>, <?= $data->ip ?>)</span>
			<?php endif; ?>

			<?php if (!empty($data->reply)): ?>
				<br /><span style="color:#ff0000">Ответ: <?= $data->reply ?></span>
			<?php endif; ?>

		</div>
	<?php endforeach; ?>

	<?php page_strnavigation('index.php?', $config['bookpost'], $start, $total); ?>

<?php else: ?>
	<?php show_error('Сообщений нет, будь первым!'); ?>
<?php endif; ?>


<?php if (is_user()): ?>
	<div class="form">
		<form action="index.php?act=add&amp;uid=<?= $_SESSION['token'] ?>" method="post">

		<textarea id="markItUp" cols="25" rows="5" name="msg"></textarea><br />
		<input type="submit" value="Написать" /></form>
	</div><br />

<?php elseif ($config['bookadds'] == 1): ?>

	<div class="form">
		<form action="index.php?act=add&amp;uid=<?= $_SESSION['token'] ?>" method="post">
		Сообщение:<br />
		<textarea cols="25" rows="5" name="msg"></textarea><br />

		Проверочный код:<br />
		<img src="/gallery/protect.php" alt="" /><br />
		<input name="provkod" size="6" maxlength="6" /><br />

		<input type="submit" value="Написать" /></form>
	</div><br />

<?php else: ?>
	<?php show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо'); ?>
<?php endif; ?>

