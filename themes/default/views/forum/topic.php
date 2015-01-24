<a href="index.php">Форум</a> /

<?php if ($topic->forum): ?>

	<?php if ($topic->forum->parent_id): ?>
		<a href="forum.php?fid=<?= $topic->forum()->parent_id ?>"><?= $topic->forum()->parent()->title ?></a> /
	<?php endif; ?>

	<a href="forum.php?fid=<?= $topic->forum()->id ?>"><?= $topic->forum()->title ?></a> /
<?php endif; ?>

<a href="print.php?tid=<?= $tid ?>">Скачать</a> / <a href="rss.php?tid=<?= $tid ?>">RSS-лента</a>

<?php if (is_user()): ?>
<?php /*
	(
	<?php if ($topics['topics_author'] == $log && empty($topics['topics_closed']) && $udata['users_point'] >= $config['editforumpoint']): ?>
		<a href="topic.php?act=closed&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>">Закрыть</a> /
		<a href="topic.php?act=edittopic&amp;tid=<?= $tid ?>">Изменить</a> /
	<?php endif; ?>
*/?>

	/ <a href="#" onclick="return changeBookmark(this, <?= $tid ?>)" data-token="<?= $_SESSION['token'] ?>"><?= $topic->is_bookmarked($current_user->id) ? 'Из закладок' : 'В закладки' ?></a>


<?php endif; ?>

<?php if ($topic->mods): ?>

	<div class="bg-success">
		Модераторы темы:
		<?= $topic->getModerators() ?>
	</div>
<?php endif; ?>

<?php if ($topic->note): ?>
	<div class="bg-warning"><?= bb_code($topic->note) ?></div>
<?php endif; ?>

<hr />


<?php if (is_admin()): ?>
	<?php if ($topic->closed): ?>
		<a href="/admin/forum.php?act=acttopic&amp;do=open&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>">Открыть</a> /
	<?php else: ?>
		<a href="/admin/forum.php?act=acttopic&amp;do=closed&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>">Закрыть</a> /
	<?php endif; ?>

	<?php if ($topic->locked): ?>
		<a href="/admin/forum.php?act=acttopic&amp;do=unlocked&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>">Открепить</a> /
	<?php else: ?>
		<a href="/admin/forum.php?act=acttopic&amp;do=locked&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>">Закрепить</a> /
	<?php endif; ?>

	<a href="/admin/forum.php?act=edittopic&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>">Изменить</a> /
	<a href="/admin/forum.php?act=movetopic&amp;tid=<?= $tid ?>">Переместить</a> /
	<a href="/admin/forum.php?act=deltopics&amp;fid=<?= $topic->forum_id ?>&amp;del=<?= $tid ?>&amp;token=<?= $_SESSION['token'] ?>" onclick="return confirm('Вы действительно хотите удалить данную тему?')">Удалить</a> /
	<a href="/admin/forum.php?act=topic&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>">Управление</a><br />
<?php endif; ?>


<?php if ($topic->posts): ?>
<?php foreach ($topic->posts as $key => $post): ?>
	<?php $num = ($start + $key + 1); ?>

		<div class="media">

			<?= user_avatars($post->user()->id) ?>

			<div class="media-body">
				<div class="media-heading">

					<?= $num ?>. <h4 class="author"><?= profile($post->user()->login) ?></h4>
					<?= user_title($post->user_id) ?> <?= user_online($post->user_id) ?>

					<ul class="list-inline small pull-right">

					<?php if ($current_user->id && $current_user->id != $post->user_id): ?>

						<li><a href="#" onclick="return postReply('<?= $post->user()->login ?>')" data-toggle="tooltip" title="Ответить"><span class="fa fa-reply text-muted"></span></a></li>

						<li><a href="#" onclick="return postQuote(this);" data-toggle="tooltip" title="Цитировать"><span class="fa fa-quote-right text-muted"></span></a></li>

						<li><a href="#" onclick="return sendComplaint(this, 'forum', <?= $post->id ?>);" data-token="<?= $_SESSION['token'] ?>" rel="nofollow" data-toggle="tooltip" title="Жалоба"><span class="fa fa-bell text-muted"></span></a></li>

					<?php endif; ?>

					<?php if ($current_user->id && $current_user->id == $post->user_id && $post->created_at->getTimestamp() > time() - 600): ?>
						<li><a href="index.php?act=edit&amp;id=<?= $post->id ?>&amp;start=<?= $start ?>" data-toggle="tooltip" title="Редактировать"><span class="fa fa-pencil text-muted"></span></a></li>
					<?php endif; ?>

					<?php if (!empty($topics['is_moder'])): /* ?>
							<li><a href="topic.php?act=modedit&amp;tid=<?= $tid ?>&amp;pid=<?=$data['posts_id']?>&amp;start=<?= $start ?>">Удалить</a></li>
							<li><a href="topic.php?act=modedit&amp;tid=<?= $tid ?>&amp;pid=<?=$data['posts_id']?>&amp;start=<?= $start ?>">Ред.</a></li>
					<?php */ endif; ?>

						<li class="text-muted date"><?= $post->created_at ?></li>
					</ul>
				</div>

				<div class="message"><?= bb_code($post->text) ?></div>

				<?php if (!empty($post->edit_user_id)): ?>
					<div class="small text-muted"><span class="glyphicon glyphicon-pencil"></span> Отредактировано: <?= $post->user()->login ?> (<?= $post->updated_at ?>)</div>
				<?php endif; ?>

				<?php if (is_admin()): ?>
					<div class="small text-danger"><?= $post->ip ?>, <?= $post->brow ?></div>
				<?php endif; ?>

			</div>
		</div>


		<?php if (!empty($topics['posts_files'])): ?>
			<?php if (isset($topics['posts_files'][$data['posts_id']])): ?>
				<div class="hide"><img src="/images/img/paper-clip.gif" alt="attach" /> <b>Прикрепленные файлы:</b><br />
				<?php foreach ($topics['posts_files'][$data['posts_id']] as $file): ?>
					<?php $ext = getExtension($file['file_hash']); ?>
					<img src="/images/icons/<?=icons($ext)?>" alt="image" />

					<a href="/upload/forum/<?=$topics['topics_id']?>/<?=$file['file_hash']?>"><?=$file['file_name']?></a> (<?=formatsize($file['file_size'])?>)<br />
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	<?php endforeach; ?>

<?php elseif(!$topic->closed): ?>
	<?php show_error('Сообщений еще нет, будь первым!'); ?>
<?php endif; ?>

<?php page_strnavigation('topic.php?tid='.$tid.'&amp;', $config['forumpost'], $start, $total); ?>

<?php if (is_user()): ?>
	<?php if(!$topic->closed): ?>
		<div class="well">
			<form action="topic.php?act=add&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>&amp;token=<?= $_SESSION['token'] ?>" method="post">
				<div class="form-group">
					<textarea class="form-control" id="markItUp" cols="25" rows="5" name="msg"></textarea>
				</div>
				<button type="submit" class="btn btn-action">Написать</button>

		<?php if ($udata['users_point'] >= $config['forumloadpoints']): ?>
			<span class="imgright">
				<a href="topic.php?act=addfile&amp;tid=<?= $tid ?>&amp;start=<?= $start ?>">Загрузить файл</a>
			</span>
		<?php endif; ?>
			</form>
		</div>

	<?php else: ?>
		<?php show_error('Данная тема закрыта для обсуждения!'); ?>
	<?php endif; ?>
<?php else: ?>
	<?php show_login('Вы не авторизованы, чтобы добавить сообщение, необходимо'); ?>
<?php endif; ?>

<a href="/pages/smiles.php">Смайлы</a>  /
<a href="/pages/tags.php">Теги</a>  /
<a href="/pages/rules.php">Правила</a> /
<a href="top.php?act=themes">Топ тем</a> /
<a href="search.php?fid=<?= $topic->id ?>">Поиск</a><br />
