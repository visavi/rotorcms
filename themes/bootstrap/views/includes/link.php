<?php $links = prepare_array($links); ?>

<?php if (count($links)): ?>
	<div class="breadcrumbs">

		<?php foreach ($links as $key=>$link): ?>
			<?php $params = null;
			if (isset($link['params'])) {
				foreach ($link['params'] as $name=>$val){
					$params .= " {$name}=\"{$val}\"";
				}
			} ?>
			<?php if (!empty($key)) echo '/'; ?>

			<?php if (isset($link['url'])): ?>
				<a href="<?= $link['url'] ?>"<?= $params ?>><?= $link['label'] ?></a>
			<?php else: ?>
				<span<?= $params ?>><?= $link['label'] ?></span>
			<?php endif; ?>

		<?php endforeach; ?>
	</div>
<?php endif; ?>
