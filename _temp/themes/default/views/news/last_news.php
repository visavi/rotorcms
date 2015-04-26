<?php if ($news): ?>
	<?php foreach ($news as $data): ?>

		<div class="spoiler">
			<b class="spoiler-title"><?= $data->title ?></b>
			<div class="spoiler-text" style="display: none;">
				<?= bb_code($data->text) ?><br />
				<a href="/news/index.php?act=comments&amp;id=<?= $data->id ?>">Комментарии</a> (<?= $data->commentCount() ?>)
			</div>
		</div>

	<?php endforeach; ?>
<?php endif; ?>
