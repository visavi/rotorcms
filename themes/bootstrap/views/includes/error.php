<div class="alert alert-danger">
	<?php if (is_array($errors)): ?>
		<?php foreach ($errors as $error): ?>
			<?= $error ?>
		<?php endforeach; ?>
	<?php else: ?>
		<?= $errors ?>
	<?php endif; ?>
</div>



