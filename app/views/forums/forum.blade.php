@extends('layout')

@section('title', $forum->title.' - @parent')
@section('breadcrumbs', App::breadcrumbs(['/forum' => 'Форум', $forum->title]))

@section('content')
	<h1 class="inline-block">{{ $forum->title }}

	@if (!$forum->closed)
		 <a class="btn btn-success pull-right" href="/forum/{{ $forum->id }}/create">Создать тему</a>
	@endif
</h1>

	@if ($forum->parent_id)
		/ <a href="forum.php?fid=<?= $forum->parent_id ?>"><?= $forum->parent()->title ?></a>
	@endif


<?php /*if ($forum->children && empty($start)): ?>
	<?php foreach ($forum->children as $subforum): ?>
		<div>
			<h4>
				<a class="touch-link" href="forum.php?fid=<?= $subforum->id ?>">
					<span class="glyphicon glyphicon-comment"></span>
					<?= $subforum->title ?>
					<span class="badge"><?= $subforum->topicCount() ?>/<?= $subforum->topicLast()->postCount() ?></span>
				</a>
			</h4>

			<?php if ($subforum->description): ?>
				<span class="help-block"><?= $subforum->description ?></span>
			<?php endif; ?>

			<?php if ($subforum->topic_last): ?>
				Тема: <a href="topic.php?act=end&amp;tid=<?= $subforum->topicLast()->id ?>"><?= $subforum->topicLast()->title ?></a><br />

				<?php if ($subforum->topicLast()->postLast()->user()->id): ?>
					Сообщение: <?= $subforum->topicLast()->postLast()->user()->getLogin() ?> (<?= $subforum->topicLast()->postLast()->created_at ?>)
				<?php endif; ?>

			<?php else: ?>
				Темы еще не созданы!
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
<?php endif;*/ ?>

@if ($topics)
	@foreach ($topics as $topic)
		<h5 id="topic_{{ $topic->id }}">

			<a class="touch-link" href="/topic/{{ $topic->id }}">
				<span class="glyphicon {{ $topic->getIcon() }}"></span>
				{{ $topic->title }}
				<span class="badge">{{ $topic->postCount() }}</span>
			</a>
		</h5>
		<div>
			Страницы: <?php /* forum_navigation('topic.php?tid='.$topic->id.'&amp;', $config['forumpost'], $topic->postCount()) */?>

			@if ($topic->postLast()->user()->id)
				Сообщение: {{ $topic->postLast()->user()->getLogin() }} ({{ Carbon::parse($topic->postLast()->created_at)->format('d.m.y / H:i') }})
			@endif

		</div>
	@endforeach

	{{ App::pagination($page) }}

@elseif ($forum->closed)
	<div class="alert alert-danger">В данном разделе запрещено создавать темы!</div>
@else
	<div class="alert alert-danger">Тем еще нет, будь первым!</div>
@endif

<p>
	<a href="/rules">Правила</a> /
	<a href="/forum/top?act=themes">Топ тем</a> /
	<a href="/forum/search">Поиск</a>
</p>
@stop
