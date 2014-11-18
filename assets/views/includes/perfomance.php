<div>
	Производительность: &nbsp;
	 <span class="glyphicon glyphicon-tasks" data-toggle="tooltip" title="Потребление ОЗУ"></span> <?= formatsize(memory_get_usage()) ?>

	<?php if (function_exists('sys_getloadavg')): ?>
		<?php $cpu = sys_getloadavg(); ?>
		<span class="glyphicon glyphicon-dashboard" data-toggle="tooltip" title="Загрузка CPU"></span> <?= round($cpu[0], 2) ?>&nbsp;
	<?php endif; ?>

	<?php if (!empty($config['gzip'])): ?>
		<?php $compression = Compressor::result(); ?>
		<?php if (!empty($compression)) {?> <span class="glyphicon glyphicon-compressed" data-toggle="tooltip" title="Компрессия"></span> <?= $compression ?>%&nbsp; <?php }?>
	<?php endif; ?>

	<span class="glyphicon glyphicon-plane" data-toggle="tooltip" title="Загрузка страницы"></span> <?= round(microtime(1) - STARTTIME, 4) ?> сек.
</div>

