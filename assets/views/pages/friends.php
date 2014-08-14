<?php
$links = array(
	array('label' => 'Друзья ('.$total['friends'].')', 'params' => array('style' => 'font-weight: bold;')),
	array('url' => 'friends.php?act=offers', 'label' => 'Заявки ('.$total['offers'].')'),
	array('url' => 'friends.php?act=invitations', 'label' => 'Приглашения ('.$total['invitations'].')'),
);

render('includes/link', array('links' => $links));
?>

<?php if ($total['friends'] > 0): ?>
	<?php foreach ($friends as $data): ?>
		<div class="b">
			<div class="img"><?= user_avatars($data['friend']) ?></div>
			<b><?= profile($data['friend']) ?></b> <small>(<?= date_fixed($data['time']) ?>)</small><br />
			<?= user_title($data['friend']) ?> <?= user_online($data['friend']) ?>
		</div>

		<div>
			<a href="/pages/private.php?act=submit&amp;uz=<?= $data['friend'] ?>">Написать сообщение</a><br />
			<a href="/pages/friends.php?user=<?= $data['friend'] ?>">Посмотреть друзей</a><br />
			<a href="/pages/friends.php?act=delete&amp;id=<?= $data['id'] ?>">Убрать из друзей</a><br />
		</div>

	<?php endforeach; ?>

	<?= page_strnavigation('friends.php?', $config['friendlist'], $start, $total['friends']); ?>

<?php else: ?>
	<?php show_error('Список друзей пуст!'); ?>
<?php endif; ?>
