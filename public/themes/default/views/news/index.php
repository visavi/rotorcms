<?php if ($total > 0): ?>
	<?php foreach ($news_list as $news): ?>

		<div class="media">
			<?php if ($news->image): ?>
				<div class="media-left">
					<a href="/uploads/news/<?= $news->image ?>"><?= resize_image('uploads/news/', $news->image, 150, $news->title) ?></a>
				</div>
			<?php endif; ?>
			<div class="media-body">
				<div class="media-heading">
					<h3 class="author"><a href="index.php?act=read&amp;id=<?= $news->id ?>"><?= $news->title ?></a></h3>
					<span class="pull-right text-muted small date"><?= $news->created_at ?></span>
				</div>

				<div class="message"><?= bb_code($news->text, false) ?></div>
			</div>
		</div>


			if(stristr($data['news_text'], '[cut]')) {
				$data['news_text'] = current(explode('[cut]', $data['news_text'])).' <a href="index.php?act=read&amp;id='.$data['news_id'].'">Читать далее &raquo;</a>';
			}

			echo '<div>'.bb_code($data['news_text']).'</div>';
			echo '<div style="clear:both;">Добавлено: '.profile($data['news_author']).'<br />';
			echo '<a href="index.php?act=comments&amp;id='.$data['news_id'].'">Комментарии</a> ('.$data['news_comments'].') ';
			echo '<a href="index.php?act=end&amp;id='.$data['news_id'].'">&raquo;</a></div>';

	<?php endforeach; ?>

	<?php App::pagination('/news', $config['postnews'], $page, $total); ?>

<?php else: ?>
	<?php show_error('Сообщений нет, будь первым!'); ?>
<?php endif; ?>

<i class="fa fa-rss"></i> <a href="/news/rss">RSS подписка</a><br />
