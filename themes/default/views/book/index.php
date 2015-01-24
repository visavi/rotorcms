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

		<div class="media">

			<?= user_avatars($post->user()->id) ?>

			<div class="media-body">
				<div class="media-heading">

				<?php if ($post->user()->login): ?>
					<h4 class="author"><?= profile($post->user()->getLogin()) ?></h4>
					<?= user_title($post->user_id) ?> <?= user_online($post->user_id) ?>

				<?php else: ?>
					<h4 class="author"><?= $post->user()->getLogin() ?></h4>
				<?php endif; ?>

					<ul class="list-inline small pull-right">

					<?php if ($current_user->id && $current_user->id != $post->user_id): ?>
						<li><a href="#" onclick="return postReply('<?= $post->user()->getLogin() ?>');" data-toggle="tooltip" title="Ответить"><span class="fa fa-reply text-muted"></span></a></li>

						<li><a href="#" onclick="return postQuote(this);" data-toggle="tooltip" title="Цитировать"><span class="fa fa-quote-right text-muted"></span></a></li>

						<li><a href="#" onclick="return sendComplaint(this, 'guest', <?= $post->id ?>);" data-token="<?= $_SESSION['token'] ?>" rel="nofollow" data-toggle="tooltip" title="Жалоба"><span class="fa fa-bell text-muted"></span></a></li>

					<?php endif; ?>

					<?php if ($current_user->id && $current_user->id == $post->user_id && $post->created_at->getTimestamp() > time() - 600): ?>
						<li><a href="index.php?act=edit&amp;id=<?= $post->id ?>&amp;start=<?= $start ?>" data-toggle="tooltip" title="Редактировать"><span class="fa fa-pencil text-muted"></span></a></li>
					<?php endif; ?>

						<li class="text-muted date"><?= $post->created_at ?></li>
					</ul>
				</div>

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
				<textarea class="form-control" id="markItUp" rows="5" name="msg"></textarea>
			</div>
			<button type="submit" class="btn btn-action">Написать</button>
		</form>
	</div>

<?php elseif ($config['bookadds'] == 1): ?>

	<div class="well">
		<form action="index.php?act=add&amp;token=<?= $_SESSION['token'] ?>" method="post">
			<div class="form-group">
				<label for="msg">Сообщение:</label>
				<textarea class="form-control" id="msg" rows="5" name="msg"></textarea>
			</div>
			<div class="form-group">
				<label for="provkod">Проверочный код:</label>
				<img src="/gallery/protect.php" class="img-rounded" alt="" />
				<input name="provkod" id="provkod" class="form-control" maxlength="6" style="width: 200px;" />
			</div>
			<button type="submit" class="btn btn-action">Написать</button>
		</form>
	</div>

<?php else: ?>
	<?php show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо'); ?>
<?php endif; ?>

