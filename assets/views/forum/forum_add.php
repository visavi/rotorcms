<?php if ($forums): ?>
	<div class="well">
		<form action="forum.php?act=add&amp;fid=<?= $fid ?>&amp;token=<?= $_SESSION['token'] ?>" method="post">

			<label class="control-label" for="fid">Раздел:</label>
			<select name="fid" id="fid" class="form-control">

			<?php foreach ($forums as $key => $forum): ?>
				<?php $selected = ($fid == $forum->id) ? ' selected="selected"' : ''; ?>
				<option value="<?= $forum->id ?>"<?=$selected?>><?= $forum->title ?></option>

				<?php if ($forum->children): ?>
					<?php foreach($forum->children as $subforum): ?>
						<?php $selected = ($fid == $subforum->id) ? ' selected="selected"' : ''; ?>
						<option value="<?= $subforum->id ?>"<?=$selected?>>– <?= $subforum->title ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			</select><br />

			<label class="control-label" for="title">Заголовок</label>
			<input name="title" id="title" type="text" class="form-control" maxlength="50" /><br />
			<textarea name="msg" class="form-control" id="markItUp" cols="25" rows="5"></textarea><br />
			<button type="submit" class="btn btn-action">Создать тему</button>
		</form>
	</div>

	<p class="bg-info">
		Прежде чем создать новую тему необходимо ознакомиться с правилами <a href="/pages/rules.php">Правила сайта</a><br />
		Также убедись что такой темы нет, чтобы не создавать одинаковые, для этого введи ключевое слово в поиске <a href="search.php">Поиск по форуму</a><br />
		И если после этого вы уверены, что ваша тема будет интересна другим пользователям, то можете ее создать<br />
	</p>

<?php else: ?>
	<?php show_error('Разделы форума еще не созданы!'); ?>
<?php endif; ?>
