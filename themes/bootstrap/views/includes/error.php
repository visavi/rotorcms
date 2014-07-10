<?php if (is_array($errors)): ?>

	<div class="info">
		<?php foreach ($errors as $error): ?>
			<img src="/images/img/error.gif" alt="Ошибка" /> <b><?= $error ?></b><br />
		<?php endforeach; ?>
	</div>

<?php else: ?>

	<div class="info"><img src="/images/img/error.gif" alt="Ошибка" /> <b><?= $errors ?></b></div>

<?php endif; ?>
