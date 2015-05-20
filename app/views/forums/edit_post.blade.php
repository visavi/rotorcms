@extends('layout')

@section('title', 'Редактирование сообщения - @parent')
@section('breadcrumbs', App::breadcrumbs(['/forum' => 'Форум', '/topic/'.$post->topic()->id => $post->topic()->title, 'Редактирование сообщения']))

@section('content')
	<h1>Редактирование сообщения</h1>

	<div class="media" id="post">
		{!! $post->user()->getAvatar() !!} <h4 class="author"><a href="/user/{{ $post->user()->getLogin() }}">{{ $post->user()->getLogin() }}</a></h4> <small>({{ Carbon::parse($post->created_at)->format('d.m.y / H:i') }})</small>
	</div>
	<div class="well clearfix">
		<form role="form" method="post">
			<input name="token" type="hidden" value="{{ $_SESSION['token'] }}">
			<label for="markItUp">Сообщение:</label>
			<div class="form-group{{ App::hasError('text') }}">
				<textarea class="form-control" id="markItUp" rows="5" name="text" required>{{ App::getInput('text', $post->text) }}</textarea>
				{!! App::textError('text') !!}
			</div>
			<button type="submit" class="btn btn-primary pull-right">Редактировать</button>
		</form>
	</div>
@stop
