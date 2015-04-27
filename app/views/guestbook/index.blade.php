@extends('layout')

@section('title', 'Гостевая книга - @parent')

@section('breadcrumbs')
	{{ App::breadcrumbs(['Гостевая книга']) }}
@stop

@section('content')

	<h1>Гостевая книга</h1>

	@if ($total)
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
							<li><a href="#" onclick="return postReply('{{ $post->user()->getLogin() }}');" data-toggle="tooltip" title="Ответить"><span class="fa fa-reply text-muted"></span></a></li>

							<li><a href="#" onclick="return postQuote(this);" data-toggle="tooltip" title="Цитировать"><span class="fa fa-quote-right text-muted"></span></a></li>

							<li><a href="#" onclick="return sendComplaint(this, 'guest', {{ $post->id }});" data-token="{{ $_SESSION['token'] }}" rel="nofollow" data-toggle="tooltip" title="Жалоба"><span class="fa fa-bell text-muted"></span></a></li>

						@endif

						@if (User::check() && User::get('id') == $post->user_id && $post->created_at > Carbon::now()->subMinutes(10))
							<li><a href="/guestbook/{{ $post->id }}/edit" data-toggle="tooltip" title="Редактировать"><span class="fa fa-pencil text-muted"></span></a></li>
						@endif

							<li class="text-muted date">{{ Carbon::parse($post->created_at)->format('d.m.y / H:i') }}</li>
						</ul>
					</div>

					<div class="message">{!! bb_code(e($post->text)) !!}</div>

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

		{{ App::pagination(Setting::get('guestbook_per_page'), $page, $total) }}

	@else
		<div class="alert alert-danger">Сообщений нет, будь первым!</div>
	@endif


	@if (User::check())
		<div class="well clearfix">
			<form action="/guestbook/create" method="post">
				<input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

				<label for="markItUp">Сообщение:</label>
				<div class="form-group{{ App::hasError('text') }}">
					<textarea class="form-control" id="markItUp" rows="5" name="text" required>{{ App::getInput('text') }}</textarea>
					{!! App::textError('text') !!}
				</div>
				<button type="submit" class="btn btn-primary pull-right">Написать</button>
			</form>
		</div>

	@else
		<div class="well">
			<form action="/guestbook/create" method="post">
				<input type="hidden" name="token" value="{{ $_SESSION['token'] }}" />
				<div class="form-group{{ App::hasError('text') }}">
					<label for="inputText">Сообщение:</label>
					<textarea class="form-control" id="inputText" rows="5" name="text" placeholder="Текст сообщения" required>{{ App::getInput('text') }}</textarea>
					{!! App::textError('text') !!}
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4{{ App::hasError('captcha') }}">
						<input name="captcha" type="text" class="form-control" id="inputCaptcha" maxlength="6" placeholder="Проверочный код" required>
						{!! App::textError('captcha') !!}
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<img src="/captcha" id="captcha" onclick="this.src='/captcha?'+Math.random()" class="img-rounded" alt="" style="cursor: pointer;">
					</div>

					<div class="col-lg-5">
						<button type="submit" class="btn btn-primary pull-right">Написать</button>
					</div>
				</div>
			</form>
		</div>

	@endif
@stop
