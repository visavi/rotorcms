@extends('layout')

@section('title', 'Создание новой темы - @parent')
@section('breadcrumbs', App::breadcrumbs(['/forum' => 'Форум', 'Создание новой темы']))

@section('content')
	<h1>Новая тема</h1>

	@if (User::check())

		<div class="well clearfix">
			<form action="/forum/create" method="post">
				<input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

				<div class="form-group{{ App::hasError('forum_id') }}">
					<label for="inputForumId">Форум</label>
					<select class="form-control" id="inputForumId" name="forum_id">
						@foreach ($forums as $key => $forum)
							<?php $selected = ($key ==  App::getInput('forum_id', Request::input('forum'))) ? ' selected' : ''; ?>
							<option value="{{ $key }}"{{ $selected }}>{{ $forum }}</option>
						@endforeach
					</select>
					{!! App::textError('forum_id') !!}
				</div>


				<div class="form-group{{ App::hasError('title') }}">
					<label for="inputTitle">Название темы</label>
					<input name="title" type="text" class="form-control" id="inputTitle"  maxlength="50" placeholder="Название темы" value="{{ App::getInput('title') }}" required>
					{!! App::textError('title') !!}
				</div>

				<div class="form-group{{ App::hasError('text') }}">
					<label for="markItUp">Сообщение:</label>
					<textarea class="form-control" id="markItUp" rows="5" name="text" required>{{ App::getInput('text') }}</textarea>
					{!! App::textError('text') !!}
				</div>
				<button type="submit" class="btn btn-primary pull-right">Написать</button>

			</form>
		</div>


	@else
		<div class="alert alert-danger">Авторизуйтесь или зарегистрируйтесь для создания темы</div>
	@endif
@stop
