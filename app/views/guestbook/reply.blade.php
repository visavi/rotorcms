@extends('layout')

@section('title', 'Гостевая книга - @parent')
@section('breadcrumbs', App::breadcrumbs(['/guestbook' => 'Гостевая книга', 'Ответ на сообщение']))

@section('content')

{{-- 	<div class="media" id="post">
		{!! $guest->user()->getAvatar() !!} <h4 class="author"><a href="/user/{{ $guest->user()->getLogin() }}">{{ $guest->user()->getLogin() }}</a></h4> <small>({{ Carbon::parse($guest->created_at)->format('d.m.y / H:i') }})</small>
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
	</div> --}}

@stop
