<?php if ($onlines): ?>

	<?php foreach($onlines as $online): ?>

		<div class="b">
			<?= user_gender($online->user_id) ?> <b><?= profile($online->user()->getLogin()) ?></b> (Время: <?= $online->created_at->format('H:i:s') ?>
		</div>

		<?php if (is_admin()): ?>
			<div><span class="data"><?= $online->brow ?>, <?= $online->ip ?>)</span></div>
		<?php endif; ?>

	<?php endforeach; ?>

	<?php page_strnavigation('online.php?', $config['onlinelist'], $start, $total); ?>

<?php else: ?>
	<?php show_error('Авторизованных пользователей нет!'); ?>
<?php endif; ?>
