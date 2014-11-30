<?php if ($users): ?>

	<?php foreach($users as $key => $user): ?>

		echo '<div class="b"> ';
		echo '<div class="img">'.user_avatars($data['users_login']).'</div>';

		if ($uz == $data['users_login']) {
			echo ($start + $i).'. <b><big>'.profile($data['users_login'], '#ff0000').'</big></b> ';
		} else {
			echo ($start + $i).'. <b>'.profile($data['users_login']).'</b> ';
		}
		echo '('.points($data['users_point']).')<br />';
		echo user_title($data['users_login']).' '.user_online($data['users_login']);
		echo '</div>';

		echo '<div>';
		echo 'Форум: '.$data['users_allforum'].' | Гостевая: '.$data['users_allguest'].' | Коммент: '.$data['users_allcomments'].'<br />';
		echo 'Посещений: '.$data['users_visits'].'<br />';
		echo 'Деньги: '.user_money($data['users_login']).'<br />';
		echo 'Дата регистрации: '.date_fixed($data['users_joined'], 'j F Y').'</div>';


	<?php endforeach; ?>

	<?php page_strnavigation('online.php?', $config['userlist'], $start, $total); ?>


	<div class="well">
		<form class="form-inline" action="userlist.php?act=search&amp;start=<?= $start ?>" method="post">
		<label for="uz">Поиск пользователя:</label><br />
		<div class="form-group">
			<input type="text" class="form-control" name="uz" id="uz" value="<?= $user->id ?>" />
		</div>
		<input type="submit"  class="btn btn-action" value="Искать" /></form>
	</div>

	<div class="bg-info padding">Всего пользователей: <b><?= $total ?></b></div>

<?php else: ?>
	<?php show_error('Пользователи не найдены!'); ?>
<?php endif; ?>
