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

		<div class="media" id="post">

			<?= user_avatars($post->user()->id) ?>

			<div class="media-body">
				<ul class="list-inline small pull-right">

				<li><a href="#" onclick="return reply('<?= $post->user()->getLogin() ?>')" data-toggle="tooltip" title="Ответить"><span class="fa fa-reply"></span></a></li>

				<?php if ($user->id && $user->id != $post->user_id): ?>
					<li><noindex><a href="#" onclick="return sendComplaint(this, 'guest', <?= $post->id ?>);" data-token="<?= $_SESSION['token'] ?>" rel="nofollow" data-toggle="tooltip" title="Жалоба"><span class="fa fa-bell"></span></a></noindex></li>


				<?php endif; ?>

				<?php if ($user->id && $user->id == $post->user_id && $post->created_at->getTimestamp() > time() - 600): ?>
					<li><a href="index.php?act=edit&amp;id=<?= $post->id ?>&amp;start=<?= $start ?>">Редактировать</a></li>
				<?php endif; ?>

					<li class="text-muted"><?= $post->created_at ?></li>
				</ul>

				<?php if ($post->user()->login): ?>

					<h4 class="media-heading" style="display: inline;"><?= profile($post->user()->getLogin()) ?></h4>
					<?= user_title($post->user_id) ?> <?= user_online($post->user_id) ?>

				<?php else: ?>
					<h4 class="media-heading"><?= $post->user()->getLogin() ?></h4>
				<?php endif; ?>

				<div class="message"><?= bb_code($post->text) ?></div>

				<?php if (!empty($post->edit_user_id)): ?>
					<div class="small text-muted"><span class="glyphicon glyphicon-pencil"></span> Отредактировано: <?= $post->user()->login ?> (<?= $post->updated_at ?>)</div>
				<?php endif; ?>

				<?php if (!empty($post->reply)): ?>
					<div class="bg-danger padding">Ответ: <?= $post->reply ?></div>
				<?php endif; ?>

				<?php if (is_admin()): ?>
					<div class="small text-danger"><?= $post->ip ?>, <?= $post->brow ?></div>
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
			<div class="form-group">
				<textarea class="form-control" id="markItUp" cols="25" rows="5" name="msg"></textarea>
			</div>
			<button type="submit" class="btn btn-action">Написать</button>
		</form>
	</div>

<?php elseif ($config['bookadds'] == 1): ?>

	<div class="well">
		<form action="index.php?act=add&amp;token=<?= $_SESSION['token'] ?>" method="post">
			<div class="form-group">
				<label for="msg">Сообщение:</label>
				<textarea class="form-control" cols="25" rows="5" name="msg" id="msg"></textarea>
			</div>
			<div class="form-group">
				<label for="provkod">Проверочный код:</label>
				<img src="/gallery/protect.php" alt="" />
				<input name="provkod" id="provkod" class="form-control" maxlength="6" style="width: 200px;" />
			</div>
			<button type="submit" class="btn btn-action">Написать</button>
		</form>
	</div>

<?php else: ?>
	<?php show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо'); ?>
<?php endif; ?>

