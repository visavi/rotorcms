<?php if ($users): ?>

	<a class="touch-back<?= (empty($list) || $list == 'all' ? ' bg-success' : '') ?>" href="/users">Все <span class="badge"><?= $total['users'] ?></span></a> <a class="touch-back<?= ($list == 'admins' ? ' bg-success' : '') ?>" href="/users?list=admins">Администрация <span class="badge"><?= $total['admins'] ?></span></a>

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

	<?php App::pagination('/users?list='.$list, $config['userlist'], $page, $total['all']); ?>

	<div class="well">
		<form class="form-inline" action="/users/search" method="post">
		<label for="login">Поиск пользователя:</label><br />
		<div class="form-group">
			<input type="text" class="form-control" name="login" value="<?= $current_user->getLogin() ?>" />
		</div>
		<input type="submit"  class="btn btn-action" value="Поиск" /></form>
	</div>

<?php else: ?>
	<?php show_error('Пользователи не найдены!'); ?>
<?php endif; ?>
