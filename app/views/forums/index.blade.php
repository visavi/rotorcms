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
						<span class="glyphicon glyphicon-comment"></span>
						{{ $forum->title }}
						<span class="badge">{{ $forum->topicCount() }}/{{ $forum->topicLast()->postCount() }}</span>
					</a>
				</h4>

			@if ($forum->description)
				<span class="help-block">{{ $forum->description }}</span>
			@endif

			@if ($forum->children)
				@foreach($forum->children as $subforum)
					<h5>
						<span class="glyphicon glyphicon-folder-open"></span>
						<a href="forum/{{ $subforum->id }}">{{ $subforum->title }}</a>
						<span class="badge">{{ $subforum->topicCount() }}/{{ $subforum->topicLast()->postCount() }}</span>
					</h5>
				@endforeach
			@endif

			@if ($forum->topic_last)
				Тема: <a href="topic.php?act=end&amp;tid={{ $forum->topicLast()->id }}">{{ $forum->topicLast()->title }}</a><br>
				@if ($forum->topicLast()->postLast()->user()->id)
					Сообщение: {{ $forum->topicLast()->postLast()->user()->getLogin() }} ({{ $forum->topicLast()->postLast()->created_at }})
				@endif
			@else
				Темы еще не созданы!
			@endif

			</div>
		@endforeach

	@else
		<div class="alert alert-danger">Разделы форума еще не созданы!</div>
	@endif

	<p><a href="/pages/rules.php">Правила</a> / <a href="top.php?act=themes">Топ тем</a> / <a href="search.php">Поиск</a></p>
@stop
