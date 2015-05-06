@extends('layout')

@section('title', $topic->title.' - @parent')
@section('breadcrumbs', App::breadcrumbs($crumbs))

@section('content')

	<h1>{{ $topic->title }}</h1>

	@if (User::check())
		<a href="#" onclick="return changeBookmark(this)" data-id="{{ $topic->id }}" data-token="{{ $_SESSION['token'] }}">{{ $topic->isBookmarked(User::get('id')) ? 'Из закладок' : 'В закладки' }}</a>
	@endif

	@if ($topic->mods)
		<div class="bg-success">
			Модераторы темы:
			{{ $topic->getModerators() }}
		</div>
	@endif

	@if ($topic->note)
		<div class="bg-warning">{!! App::bbCode(e($topic->note)) !!}</div>
	@endif


	@if ($posts)
		@foreach ($posts as $key => $post)
			<div class="media">
				<div class="media-left">
					{!! $post->user()->getAvatar() !!}
				</div>

				<div class="media-body">
					<div class="media-heading">

						{{ $key + $page['offset'] + 1 }}. <h4 class="author"><a href="/user/{{ $post->user()->getLogin() }}">{{ $post->user()->getLogin() }}</a></h4>

						<ul class="list-inline small pull-right">

						@if (User::check() && User::get('id') != $post->user_id)

							<li><a href="#" onclick="return postReply('{{ $post->user()->login }}')" data-toggle="tooltip" title="Ответить"><span class="fa fa-reply text-muted"></span></a></li>

							<li><a href="#" onclick="return postQuote(this)" data-toggle="tooltip" title="Цитировать"><span class="fa fa-quote-right text-muted"></span></a></li>

							<li><a href="#" onclick="return sendComplaint(this)" data-type="guest" data-id="{{ $post->id }}" data-token="{{ $_SESSION['token'] }}" rel="nofollow" data-toggle="tooltip" title="Жалоба"><span class="fa fa-bell text-muted"></span></a></li>

						@endif

						@if (User::check() && User::get('id') == $post->user_id && $post->created_at > Carbon::now()->subMinutes(10))
							<li><a href="index.php?act=edit&amp;id={{ $post->id }}" data-toggle="tooltip" title="Редактировать"><span class="fa fa-pencil text-muted"></span></a></li>
						@endif

						<?php if (!empty($topics['is_moder'])): /* ?>
								<li><a href="topic.php?act=modedit&amp;tid=<?= $tid ?>&amp;pid=<?=$data['posts_id']?>&amp;start=<?= $start ?>">Удалить</a></li>
								<li><a href="topic.php?act=modedit&amp;tid=<?= $tid ?>&amp;pid=<?=$data['posts_id']?>&amp;start=<?= $start ?>">Ред.</a></li>
						<?php */ endif; ?>

							<li class="text-muted date">{{ Carbon::parse($post->created_at)->format('d.m.y / H:i') }}</li>
						</ul>
					</div>

					<div class="message">{!! App::bbCode(e($post->text)) !!}</div>

					@if (!empty($post->edit_user_id))
						<div class="small text-muted"><span class="glyphicon glyphicon-pencil"></span> Отредактировано: <?= $post->user()->login ?> (<?= $post->updated_at ?>)</div>
					@endif

					@if (User::isAdmin())
						<div class="small text-danger">{{ $post->ip }}, {{ $post->brow }}</div>
					@endif

				</div>
			</div>


			<?php /*if (!empty($topics['posts_files'])): ?>
				<?php if (isset($topics['posts_files'][$data['posts_id']])): ?>
					<div class="hide"><img src="/images/img/paper-clip.gif" alt="attach" /> <b>Прикрепленные файлы:</b><br />
					<?php foreach ($topics['posts_files'][$data['posts_id']] as $file): ?>
						<?php $ext = getExtension($file['file_hash']); ?>
						<img src="/images/icons/<?=icons($ext)?>" alt="image" />

						<a href="/uploads/forum/<?=$topics['topics_id']?>/<?=$file['file_hash']?>"><?=$file['file_name']?></a> (<?=formatsize($file['file_size'])?>)<br />
					<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; */?>

		@endforeach

		{{ App::pagination($page) }}

	@elseif(!$topic->closed)
		<div class="alert alert-danger">Сообщений еще нет, будь первым!</div>
	@endif

	{{ App::view('forums._create_post', compact('topic')) }}

@stop
