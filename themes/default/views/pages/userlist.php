<?php if ($users): ?>

	<?php foreach($users as $key => $user): ?>

		<div class="media">
			<?= user_avatars($user->id) ?>
			<div class="media-body">

				<?= ($key + 1) ?>. <h4 class="media-heading" style="display: inline;"><?= profile($user->getLogin()) ?></h4>
				<?= user_title($user->id) ?> <?= user_online($user->id) ?>

				<ul class="list-inline small pull-right">
					<li><?= points($user->point) ?></li>
					<li>Репутация: <?= ($user->rating > 0) ? '+'.$user->rating : $user->rating ?></li>
					<li class="text-muted"><?= $user->created_at->format('d.m.Y') ?></li>
				</ul>

				<div>
					Деньги: <?= moneys($user->money) ?><br />
					Форум: <?= $user->allforum ?> / Гостевая: <?= $user->allguest ?> / Коммент: <?= $user->allcomments ?><br />
				</div>
			</div>
		</div>


<?php /*
		if ($uz == $data['users_login']) {
			echo ($start + $i).'. <b><big>'.profile($data['users_login'], '#ff0000').'</big></b> ';
		} else {
			echo ($start + $i).'. <b>'.profile($data['users_login']).'</b> ';
		}
*/ ?>
	<?php endforeach; ?>

	<?php page_strnavigation('online.php?', $config['userlist'], $start, $total); ?>


	<div class="well">
		<form class="form-inline" action="userlist.php?act=search&amp;start=<?= $start ?>" method="post">
		<label for="uz">Поиск пользователя:</label><br />
		<div class="form-group">
			<input type="text" class="form-control" name="uz" id="uz" value="<?= $user->getLogin() ?>" />
		</div>
		<input type="submit"  class="btn btn-action" value="Искать" /></form>
	</div>

	<div class="bg-info padding">Всего пользователей: <b><?= $total ?></b></div>

<?php else: ?>
	<?php show_error('Пользователи не найдены!'); ?>
<?php endif; ?>
