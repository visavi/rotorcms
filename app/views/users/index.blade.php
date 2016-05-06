@extends('layout')

@section('title', 'Список пользователей - @parent')
@section('breadcrumbs', App::breadcrumbs(['Пользователи']))

@section('content')

	<h1>Список пользователей</h1>

	<a class="touch-back{{ $list == 'all' ? ' bg-success' : '' }}" href="/users" style="margin-bottom: 5px;">Все <span class="badge">{{ $count['users'] }}</span></a> <a class="touch-back{{ $list == 'admins' ? ' bg-success' : '' }}" href="/users?list=admins">Администрация <span class="badge">{{ $count['admins'] }}</span></a>

	@if ($users)
		@foreach ($users as $key => $user)
			<div class="media{{ strtolower($login) == strtolower($user->getLogin()) ? ' bg-success padding' : '' }}">
				<div class="media-left">
					{!! $user->getAvatar() !!}
				</div>
				<div class="media-body">

					{{ ($key + $page['offset'] + 1) }}. <h4 class="author"><a href="/user/{{ $user->getLogin() }}">{{ $user->getLogin() }}</a></h4>
					<ul class="list-inline small pull-right">
						<li class="text-muted">Регистрация: {{ Carbon::parse($user->created_at)->format('d.m.y / H:i') }}</li>
					</ul>

					<div>
						{{ $user->point }} / {{ $user->money }} / Репутация: {{ ($user->rating > 0) ? '+'.$user->rating : $user->rating }}
					</div>
				</div>
			</div>
		@endforeach

		{{ App::pagination($page) }}

		<div class="well">
			<form class="form-inline" method="post">
				<label for="inputLogin">Поиск пользователя:</label><br>
				<div class="form-group">
					<input type="text" class="form-control" name="login" id="inputLogin" value="{{ !empty($login) ? $login : User::get('login') }}">
				</div>
				<button type="submit" class="btn btn-default">Поиск</button>
			</form>
		</div>

	@else
		<div class="alert alert-danger">Пользователей еще нет!</div>
	@endif
@stop
