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
				@if ($news->image)
					<div class="media-left">
						<a href="/uploads/news/{{ $news->image }}">картинка</a>
					</div>
				@endif
				<div class="media-body">
					<div class="media-heading">
						<h3 class="author"><a href="/news/{{ $news->id }}">{{ $news->title }}</a></h3>
						<span class="pull-right text-muted small date">{{ Carbon::parse($news->created_at)->format('d.m.y / H:i') }}</span>
					</div>

					<div>{!! App::bbCode(str_limit(e($news->text))) !!}</div>
				</div>
				<div>
					<span class="fa fa-user"></span> <a href="/user/{{ $news->user()->getLogin() }}">{{ $news->user()->getLogin() }}</a>, <span class="fa fa-comment"></span> <a href="/news/{{ $news->id }}#comments">{{ App::plural($news->commentCount(), ['комментарий', 'комментария', 'комментариев']) }}</a>
				</div>
			</div>
		@endforeach

		{{ App::pagination($page) }}

	@else
		<div class="alert alert-danger">Новостей еще нет!</div>
	@endif

	<p><span class="fa fa-rss"></span> <a href="/news/rss">RSS</a></p>
@stop
