<?= var_dump($forums) ?>

<?php if (count($forums) > 0): ?>
	<div class="form">
		<form action="forum.php?act=add&amp;fid=<?= $fid ?>&amp;uid=<?= $_SESSION['token'] ?>" method="post">

			Раздел:<br />
			<select name="fid">

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

			Заголовок:<br />
			<input type="text" name="title" size="50" maxlength="50" /><br />
			<textarea id="markItUp" cols="25" rows="5" name="msg"></textarea><br />
			<input value="Создать тему" type="submit" />
		</form>
	</div><br />

	Прежде чем создать новую тему необходимо ознакомиться с правилами<br />
	<a href="/pages/rules.php">Правила сайта</a><br />
	Также убедись что такой темы нет, чтобы не создавать одинаковые, для этого введи ключевое слово в поиске<br />
	<a href="search.php">Поиск по форуму</a><br />
	И если после этого вы уверены, что ваша тема будет интересна другим пользователям, то можете ее создать<br /><br />

<?php else: ?>
	<?php show_error('Разделы форума еще не созданы!'); ?>
<?php endif; ?>
