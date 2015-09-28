@extends('layout')

@section('title', $news->title.' - @parent')
@section('breadcrumbs', App::breadcrumbs(['/news' => 'Новости сайта', $news->title]))

@section('content')

	<h1>{{ $news->title }}</h1>

	<div class="media">
		@if ($news->image)
			<div class="media-left">
				<a href="/uploads/news/{{ $news->image }}">картинка</a>
			</div>
		@endif
		<div class="media-body">
			<span class="pull-right text-muted small date">{{ Carbon::parse($news->created_at)->format('d.m.y / H:i') }}</span>

			<div>{!! App::bbCode(str_limit(e($news->text))) !!}</div>
		</div>
		<div>
			<span class="fa fa-user"></span> <a href="/user/{{ $news->user()->getLogin() }}">{{ $news->user()->getLogin() }}</a>, <span class="fa fa-comment"></span> <a href="/news/{{ $news->id }}#comments">{{ App::plural($news->commentCount(), ['комментарий', 'комментария', 'комментариев']) }}</a>
		</div>
	</div>
@stop
