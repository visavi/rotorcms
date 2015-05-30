@extends('layout')

@section('title', 'Новости сайта - @parent')
@section('breadcrumbs', App::breadcrumbs(['Новости сайта']))

@section('content')

	<div class="row">
		<div class="col-sm-10">
			<h1>Новости сайта</h1>
		</div>
		<div class="col-sm-2">
			@if (User::isAdmin())
				<a class="btn btn-success" href="/news/create">Добавить новость</a>
			@endif
		</div>
	</div>

	@if ($news_list)
		@foreach ($news_list as $news)

			<div class="media">
				<?php if ($news->image): ?>
					<div class="media-left">
						<a href="/uploads/news/<?= $news->image ?>">картинка</a>
					</div>
				<?php endif; ?>
				<div class="media-body">
					<div class="media-heading">
						<h3 class="author"><a href="/news/<?= $news->id ?>"><?= $news->title ?></a></h3>
						<span class="pull-right text-muted small date"><?= Carbon::parse($news->created_at)->format('d.m.y / H:i') ?></span>
					</div>

					<div class="message">{{ App::bbCode($news->text, false) }}</div>
				</div>
			</div>


				if(stristr($data['news_text'], '[cut]')) {
					$data['news_text'] = current(explode('[cut]', $data['news_text'])).' <a href="index.php?act=read&amp;id='.$data['news_id'].'">Читать далее &raquo;</a>';
				}

				echo '<div>'.bb_code($data['news_text']).'</div>';
				echo '<div style="clear:both;">Добавлено: '.profile($data['news_author']).'<br />';
				echo '<a href="index.php?act=comments&amp;id='.$data['news_id'].'">Комментарии</a> ('.$data['news_comments'].') ';
				echo '<a href="index.php?act=end&amp;id='.$data['news_id'].'">&raquo;</a></div>';

		@endforeach

		{{ App::pagination($page) }}

	@else
		<div class="alert alert-danger">Новостей еще нет!</div>
	@endif

@stop
