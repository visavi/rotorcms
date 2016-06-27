@extends('layout')

@section('title', $news->title.' - @parent')
@section('breadcrumbs', App::breadcrumbs(['/news' => 'Новости сайта', $news->title]))

@section('content')
	<h1>{{ $news->title }}</h1>

	<div class="media">
		@if ($news->image)
			<img src="/uploads/news/images/{{ $news->image }}" alt="" class="img-responsive" />
		@endif
		<div class="media-body">
			<span class="pull-right text-muted small date">{{ Carbon::parse($news->created_at)->format('d.m.y / H:i') }}</span>

			<div>{!! App::bbCode(str_limit(e($news->text))) !!}</div>
		</div>
		<div>
			<i class="fa fa-user"></i> <a href="/user/{{ $news->user()->getLogin() }}">{{ $news->user()->getLogin() }}</a>

			@if ($news->tags())
				<i class="fa fa-tags"></i> {{ $news->tags() }}
			@endif
		</div>
	</div>

	{{ App::view('news._comments', compact('news')) }}
@stop
