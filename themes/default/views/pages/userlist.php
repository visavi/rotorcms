<?php if ($users): ?>

	<?php foreach($users as $key => $user): ?>

		<div class="media<?= ($login == $user->getLogin() ? ' bg-success padding' : '') ?>">
			<?= user_avatars($user->id) ?>
			<div class="media-body">

				<?= ($key + 1) ?>. <h4 class="media-heading" style="display: inline;"><?= profile($user->getLogin()) ?></h4>
				<?= user_title($user->id) ?> <?= user_online($user->id) ?>

				<ul class="list-inline small pull-right">
					<li class="text-muted">Регистрация: <?= $user->created_at->format('d.m.Y') ?></li>
				</ul>

				<div>
					<?= points($user->point) ?> / <?= moneys($user->money) ?> / Репутация: <?= ($user->rating > 0) ? '+'.$user->rating : $user->rating ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<?php page_strnavigation('online.php?', $config['userlist'], $start, $total); ?>

	<div class="well">
		<form class="form-inline" action="userlist.php?act=search&amp;start=<?= $start ?>" method="post">
		<label for="login">Поиск пользователя:</label><br />
		<div class="form-group">
			<input type="text" class="form-control" name="login" value="<?= $current_user->getLogin() ?>" />
		</div>
		<input type="submit"  class="btn btn-action" value="Поиск" /></form>
	</div>

	<div class="bg-info padding">Всего пользователей: <?= $total ?></div>

<?php else: ?>
	<?php show_error('Пользователи не найдены!'); ?>
<?php endif; ?>
