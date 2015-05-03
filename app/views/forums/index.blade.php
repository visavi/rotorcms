@extends('layout')

@section('title', 'Форум - @parent')
@section('breadcrumbs', App::breadcrumbs(['Форум']))

@section('content')

	<h1>Форум</h1>

	@if ($forums)
		@if (User::check())
			Мои: <a href="/forum/active?act=themes">темы</a>, <a href="/forum/active?act=posts">сообщения</a>, <a href="bookmark.php">закладки</a> /
		@endif

		Новые: <a href="/forum/new?act=themes">темы</a>, <a href="/forum/new?act=posts">сообщения</a>

		@foreach($forums as $forum)
			<div>
				<h4>
					<a class="touch-link" href="forum/{{ $forum->id }}">
						<i class="fa fa-comment"></i>
						{{ $forum->title }}
						<span class="badge">{{ App::plural($forum->topicCount(), ['тема', 'темы', 'тем']) }}</span>
					</a>
				</h4>

			@if ($forum->description)
				<span class="help-block">{{ $forum->description }}</span>
			@endif

			@if ($forum->children)
				@foreach($forum->children as $subforum)
					<h5>
						<i class="fa fa-folder-open"></i>
						<a href="forum/{{ $subforum->id }}">{{ $subforum->title }}</a>
						<span class="badge">{{ $subforum->topicCount() }}/{{ $subforum->topicLast()->postCount() }}</span>
					</h5>
				@endforeach
			@endif

			@if ($forum->topic_last)
				Тема: <a href="/topic/{{ $forum->topicLast()->id }}">{{ $forum->topicLast()->title }}</a><br>
				@if ($forum->topicLast()->postLast()->user()->id)
					Сообщение: {{ $forum->topicLast()->postLast()->user()->getLogin() }} ({{ Carbon::parse($forum->topicLast()->postLast()->created_at)->format('d.m.y / H:i') }})
				@endif
			@else
				Темы еще не созданы!
			@endif

			</div>
		@endforeach

	@else
		<div class="alert alert-danger">Разделы форума еще не созданы!</div>
	@endif

	<p><a href="/rules">Правила</a> / <a href="/forum/top?act=themes">Топ тем</a> / <a href="/forum/search">Поиск</a></p>
@stop
