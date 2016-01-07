@extends('layout')

@section('title', 'Гостевая книга - @parent')
@section('breadcrumbs', App::breadcrumbs(['/guestbook' => 'Гостевая книга', 'Редактирование']))

@section('content')

	<div class="media" id="post">

		{!! $guest->getUser()->getAvatar() !!}
		@if ($guest->getUser()->login)
			<h4 class="author"><a href="/user/{{ $guest->getUser()->getLogin() }}">{{ $guest->getUser()->getLogin() }}</a></h4>
		@else
			<h4 class="author">{{ $guest->getUser()->getLogin() }}</h4>
		@endif
		 <small>({{ Carbon::parse($guest->created_at)->format('d.m.y / H:i') }})</small>
	</div>
	<div class="well clearfix">
		<form role="form" method="post">
			<input name="token" type="hidden" value="{{ $_SESSION['token'] }}">
			<label for="markItUp">Сообщение:</label>
			<div class="form-group{{ App::hasError('text') }}">
				<textarea class="form-control" id="markItUp" rows="5" name="text" required>{{ App::getInput('text', $guest->text) }}</textarea>
				{!! App::textError('text') !!}
			</div>
			<button type="submit" class="btn btn-primary pull-right">Редактировать</button>
		</form>
	</div>

@stop
