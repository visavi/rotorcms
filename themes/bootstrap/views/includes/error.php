<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php if (is_array($errors)): ?>
		<?php foreach ($errors as $error): ?>
			<?= $error ?>
		<?php endforeach; ?>
	<?php else: ?>
		<?= $errors ?>
	<?php endif; ?>
</div>



