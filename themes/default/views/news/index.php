<?php if ($total > 0): ?>
	<?php foreach ($news_list as $news): ?>

		<div class="col-lg-12">
			<h3><a href="index.php?act=read&amp;id=<?= $news->id ?>"><?= $news->title ?></a></h3>

			<?php if ($news->image): ?>
				<div>
					<img src="/upload/news/<?= $news->image ?>" class="pull-left img-responsive" alt="Responsive image">
				</div>
				<?= $news->text ?>
			<?php endif; ?>


			<?= $news->created_at ?>
		</div>


			if (!empty($data['news_image'])) {
				echo '<div class="img"><a href="/upload/news/'.$data['news_image'].'">'.resize_image('upload/news/', $data['news_image'], 75, $data['news_title']).'</a></div>';
			}

			if(stristr($data['news_text'], '[cut]')) {
				$data['news_text'] = current(explode('[cut]', $data['news_text'])).' <a href="index.php?act=read&amp;id='.$data['news_id'].'">Читать далее &raquo;</a>';
			}

			echo '<div>'.bb_code($data['news_text']).'</div>';
			echo '<div style="clear:both;">Добавлено: '.profile($data['news_author']).'<br />';
			echo '<a href="index.php?act=comments&amp;id='.$data['news_id'].'">Комментарии</a> ('.$data['news_comments'].') ';
			echo '<a href="index.php?act=end&amp;id='.$data['news_id'].'">&raquo;</a></div>';

	<?php endforeach; ?>

	<?php page_strnavigation('index.php?', $config['postnews'], $start, $total); ?>

<?php else: ?>
	<?php show_error('Сообщений нет, будь первым!'); ?>
<?php endif; ?>

<i class="fa fa-rss"></i> <a href="/news/rss.php">RSS подписка</a><br />
