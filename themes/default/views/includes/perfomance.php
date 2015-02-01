<div>
	<span data-toggle="tooltip" title="Потребление ОЗУ"><i class="fa fa-database"></i> <?= formatsize(memory_get_usage()) ?></span>&nbsp;

	<?php if (function_exists('sys_getloadavg')): ?>
		<?php $cpu = sys_getloadavg(); ?>
		<span data-toggle="tooltip" title="Загрузка CPU"><i class="fa fa-tachometer"></i> <?= round($cpu[0], 2) ?></span>&nbsp;
	<?php endif; ?>

	<?php if ($config['gzip']): ?>
		<?php $compression = Compressor::result(); ?>
		<?php if (!empty($compression)): ?>
			<span data-toggle="tooltip" title="Компрессия"> <i class="fa fa-compress"></i> <?= $compression ?>%</span>&nbsp;
		<?php endif; ?>
	<?php endif; ?>

	<span data-toggle="tooltip" title="Загрузка страницы"><i class="fa fa-plane"></i> <?= round(microtime(1) - STARTTIME, 4) ?> сек.</span>
</div>

