<img src="/images/img/edit.gif" alt="image" /> <b><?= profile($post->user_login) ?></b> <small>(<?= date_fixed($post->created_at) ?>)</small><br /><br />

<div class="form">
	<form action="index.php?act=editpost&amp;id=<?=$id?>&amp;start=<?=$start?>&amp;uid=<?=$_SESSION['token']?>" method="post">
		<textarea id="markItUp" cols="25" rows="5" name="msg"><?=$post->text?></textarea><br />
		<input value="Редактировать" type="submit" />
	</form>
</div><br />
