@extends('layout')

@section('title', 'Профиль '.$user->login.' - @parent')

@section('breadcrumbs')
	{{ App::breadcrumbs(['/users' => 'Пользователи', $user->login]) }}
@stop

@section('content')

	<h1>{{ $user->login }}</h1>

	<div class="pull-right">
		@if (User::get('id') == $user->id)
			<a href="/user/edit" class="btn btn-sm btn-primary">Редактировать данные</a>
			<a href="/user/password" class="btn btn-sm btn-success">Изменить пароль</a>
		@endif
	</div>

	<table class="table table-hover table-striped">
		<tbody>
			<tr>
				<th>Статус</th>
				<td>{!! $user->getLevel() !!}</td>
			</tr>
			<tr>
				<th>Имя</th>
				<td>{{ $user->login }}</td>
			</tr>
			<tr>
				<th>Дата регистрации</th>
				<td>{{ $user->created_at->format('d.m.Y, H:i') }}</td>
			</tr>
		</tbody>
	</table>
@stop
