<?php
$links = array(
	array('url' => 'friends.php', 'label' => 'Друзья ('.$total['friends'].')'),
	array('label' => 'Заявки ('.$total['offers'].')', 'params' => array('style' => 'font-weight: bold;')),
	array('url' => 'friends.php?act=invitations', 'label' => 'Приглашения ('.$total['invitations'].')'),
);

render('includes/link', array('links' => $links));
?>

<?php if ($total['offers'] > 0): ?>
	<?php foreach ($offers as $data): ?>
		<div class="b">
			<div class="img"><?= user_avatars($data['user']) ?></div>
			<b><?= profile($data['user']) ?></b> <small>(<?= date_fixed($data['time']) ?>)</small><br />
			<?= user_title($data['user']) ?> <?= user_online($data['user']) ?>
		</div>

		<div>
			<a href="/pages/friends.php?act=add&amp;id=<?= $data['id'] ?>">Добавить в друзья</a><br />
			<a href="/pages/friends.php?act=delete&amp;id=<?= $data['id'] ?>">Удалить из заявок</a><br />
		</div>

	<?php endforeach; ?>

	<?= page_strnavigation('friends.php?act=offers&amp;', $config['contactlist'], $start, $total['offers']); ?>

<?php else: ?>
	<?php show_error('Список заявок пуст!'); ?>
<?php endif; ?>
