<div class="media" id="post">
	<?= user_avatars($post->user()->id) ?><h4 class="author"><?= profile($post->user()->getLogin()) ?></h4> <small>(<?= $post->created_at ?>)</small>
</div>
<div class="well">
	<form action="/guestbook/update" method="post">
		<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" />
		<input type="hidden" name="id" value="<?= $post->id ?>" />
		<div class="form-group">
			<textarea class="form-control" id="markItUp" rows="5" name="msg"><?= $post->text ?></textarea>
		</div>
		<button type="submit" class="btn btn-action">Редактировать</button>
	</form>
</div>
