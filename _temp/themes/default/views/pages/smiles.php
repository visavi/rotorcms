<ul class="breadcrumb">
	<li><a href="/">Главная</a></li>
	<li><a href="/<?= key($link) ?>"><?= current($link) ?></a></li>
	<li class="active">Смайлы</li>
</ul>

<?php if ($smiles > 0): ?>
	<?php foreach ($smiles as $smile): ?>

		<img src="/images/smiles/<?= $smile->name ?>" alt="smile" /> — <b><?= $smile->code ?></b><br />

	<?php endforeach; ?>

	<?php App::pagination('/'.key($link).'/smiles', $config['smilelist'], $page, $total); ?>

<?php else: ?>
	<?php show_error('Смайлов нет!'); ?>
<?php endif; ?>
