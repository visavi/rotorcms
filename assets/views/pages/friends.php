<?php
$links = array(
	array('label' => 'Друзья ('.$total.')', 'params' => array('style' => 'font-weight: bold;')),
	array('url' => 'friends.php?act=offers', 'label' => 'Заявки ('.$offers.')', 'show' => ($user == $log)),
	array('url' => 'friends.php?act=invitations', 'label' => 'Приглашения ('.$invitations.')', 'show' => ($user == $log)),
);

render('includes/link', array('links' => $links));
?>

<?php if ($total > 0): ?>
	<?php foreach ($friends as $data): ?>
		<div class="b">
			<div class="img"><?= user_avatars($data['friend']) ?></div>
			<b><?= profile($data['friend']) ?></b> <small>(<?= date_fixed($data['time']) ?>)</small><br />
			<?= user_title($data['friend']) ?> <?= user_online($data['friend']) ?>
		</div>

		<div>
			<a href="/pages/private.php">Написать сообщение</a><br />
			<a href="/pages/private.php">Посмотреть друзей</a><br />
			<a href="/pages/private.php">Убрать из друзей</a><br />
		</div>

	<?php endforeach; ?>

	<?= page_strnavigation('friends.php?user='.$user.'&amp;', $config['contactlist'], $start, $total); ?>

<?php else: ?>
	<?php show_error('Список друзей пуст!'); ?>
<?php endif; ?>
