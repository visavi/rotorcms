<ul class="pagination">
	<?php foreach($pages as $page): ?>
		<?php if(isset($page['separator'])): ?>
			<li><?= $page['name'] ?></li>
		<?php elseif(isset($page['current'])): ?>
			<li class="active"><span><?= $page['name'] ?></span></li>
		<?php else: ?>
			<li><a href="<?= $url ?>start=<?= $page['start'] ?>" title="<?= $page['title'] ?>"><?= $page['name'] ?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
