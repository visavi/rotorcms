@extends('layout')

@section('title', 'Гостевая книга - @parent')
@section('breadcrumbs', App::breadcrumbs(['Гостевая книга']))

@section('content')

	<h1>Гостевая книга</h1>

	@if ($posts)
		@foreach ($posts as $post)

			<div class="media">
				<div class="media-left">
					{!! $post->user()->getAvatar() !!}
				</div>

				<div class="media-body">
					<div class="media-heading">

						@if ($post->user()->login)
							<h4 class="author"><a href="/user/{{ $post->user()->getLogin() }}">{{ $post->user()->getLogin() }}</a></h4>
						@else
							<h4 class="author">{{ $post->user()->getLogin() }}</h4>
						@endif

						<ul class="list-inline small pull-right">

						@if (User::check() && User::get('id') != $post->user_id)
							<li><a href="#" onclick="return postReply('{{ $post->user()->getLogin() }}')" data-toggle="tooltip" title="Ответить"><span class="fa fa-reply text-muted"></span></a></li>

							<li><a href="#" onclick="return postQuote(this)" data-toggle="tooltip" title="Цитировать"><span class="fa fa-quote-right text-muted"></span></a></li>

							<li><a href="#" onclick="return sendComplaint(this)" data-type="guest" data-id="{{ $post->id }}" data-token="{{ $_SESSION['token'] }}" rel="nofollow" data-toggle="tooltip" title="Жалоба"><span class="fa fa-bell text-muted"></span></a></li>

						@endif

						@if (User::check() && User::get('id') == $post->user_id && $post->created_at > Carbon::now()->subMinutes(10))
							<li><a href="/guestbook/{{ $post->id }}/edit" data-toggle="tooltip" title="Редактировать"><span class="fa fa-pencil text-muted"></span></a></li>
						@endif

							<li class="text-muted date">{{ Carbon::parse($post->created_at)->format('d.m.y / H:i') }}</li>
						</ul>
					</div>

					<div class="message">{!! App::bbCode(e($post->text)) !!}</div>

					@if (!empty($post->edit_user_id))
						<div class="small text-muted"><span class="glyphicon glyphicon-pencil"></span> Отредактировано: {{ $post->user()->login }} ({{ $post->updated_at }})</div>
					@endif

					@if (!empty($post->reply))
						<div class="bg-danger padding">Ответ: {{ $post->reply }}</div>
					@endif

					@if (User::isAdmin())
						<div class="small text-danger">{{ $post->ip }}, {{ $post->brow }}</div>
					@endif

				</div>
			</div>

		@endforeach

		{{ App::pagination($page) }}

	@else
		<div class="alert alert-danger">Сообщений нет, будь первым!</div>
	@endif

	{{ App::view('guestbook._create') }}

@stop
