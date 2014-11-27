<?php if ($onlines): ?>

	<?php foreach($onlines as $online): ?>

		<div class="b">
			<?= user_gender($online->user_id) ?> <b><?= profile($online->user()->getLogin()) ?></b> (Время: <?= $online->created_at->format('H:i:s') ?>)
		</div>

		<?php if (is_admin()): ?>
			<div><span class="data"><?= $online->brow ?>, <?= $online->ip ?>)</span></div>
		<?php endif; ?>

	<?php endforeach; ?>

	<?php page_strnavigation('online.php?act='.$page, $config['onlinelist'], $start, $total); ?>

<?php else: ?>
	<?php show_error('Пользователи не найдены!'); ?>
<?php endif; ?>

<p><span class="fa fa-users"></span> <a href="online.php?act=<?= $page ?>"><?= ($page == 'index' ? 'Скрыть' : 'Показать') ?> гостей</a></p>
