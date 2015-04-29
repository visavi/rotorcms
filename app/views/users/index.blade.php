@extends('layout')

@section('title', 'Список пользователей - @parent')
@section('breadcrumbs', App::breadcrumbs(['Пользователи']))

@section('content')

	<h1>Список пользователей</h1>

	@if ($total)

		<a class="touch-back<?= (empty($list) || $list == 'all' ? ' bg-success' : '') ?>" href="/users">Все <span class="badge"><?= $total['users'] ?></span></a> <a class="touch-back<?= ($list == 'admins' ? ' bg-success' : '') ?>" href="/users?list=admins">Администрация <span class="badge"><?= $total['admins'] ?></span></a>

		@foreach ($users as $key => $user)
			<div class="media{{ $login == $user->getLogin() ? ' bg-success padding' : '' }}">
				<div class="media-left">
					{!! $user->getAvatar() !!}
				</div>
				<div class="media-body">

					{{ ($key + 1) }}. <h4 class="author"><a href="/user/{{ $user->getLogin() }}">{{ $user->getLogin() }}</a></h4>
					<ul class="list-inline small pull-right">
						<li class="text-muted">Регистрация: {{ Carbon::parse($user->created_at)->format('d.m.y / H:i') }}</li>
					</ul>

					<div>
						{{ $user->point }} / {{ $user->money }} / Репутация: {{ ($user->rating > 0) ? '+'.$user->rating : $user->rating }}
					</div>
				</div>
			</div>
		@endforeach

		{{ App::pagination(Setting::get('users_per_page'), $page, $total['all']) }}

		<div class="well">
			<form class="form-inline" method="post">
				<label for="inputLogin">Поиск пользователя:</label><br>
				<div class="form-group">
					<input type="text" class="form-control" name="login" id="inputLogin" value="{{ $login or User::get('login') }}">
				</div>
				<button type="submit" class="btn btn-default">Поиск</button>
			</form>
		</div>

	@else
		<div class="alert alert-danger">Пользователей еще нет!</div>
	@endif
@stop
