<h4 class="media-heading" style="display: inline;"><?= profile($post->user_login) ?></h4> <small>(<?= date_fixed($post->created_at) ?>)</small><br /><br />

<div class="well">
	<form action="index.php?act=editpost&amp;id=<?=$id?>&amp;start=<?=$start?>&amp;token=<?=$_SESSION['token']?>" method="post">
		<textarea class="form-control" id="markItUp" cols="25" rows="5" name="msg"><?=$post->text?></textarea><br />
		<button type="submit" class="btn btn-action">Редактировать</button>
	</form>
</div><br />
