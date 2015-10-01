@extends('layout')

@section('title', 'Профиль '.$user->login.' - @parent')
@section('breadcrumbs', App::breadcrumbs(['/users' => 'Пользователи', $user->login]))

@section('content')

	@if (User::get('id') == $user->id)
		<div class="pull-right">
			<a href="/user/edit" class="btn btn-sm btn-primary">Редактировать данные</a>
			<a href="/user/password" class="btn btn-sm btn-success">Изменить пароль</a>
		</div>
	@endif

	<h1>{!!$user->getAvatar() !!} {{ $user->login }}</h1>

	<table class="table table-hover table-striped">
		<tbody>
			<tr>
				<th>Логин</th>
				<td>{{ $user->login }}</td>
			</tr>
			<tr>
				<th>Статус</th>
				<td>{!! $user->getLevel() !!}</td>
			</tr>
			<tr>
				<th>Дата регистрации</th>
				<td>{{ Carbon::parse($user->created_at)->format('d.m.y / H:i') }}</td>
			</tr>
			<tr>
				<th>Пол</th>
				<td>{{ $user->getGender() }}</td>
			</tr>

			@if ($user->birthday)
				<tr>
					<th>День рождения</th>
					<td>{{ $user->birthday }}</td>
				</tr>
			@endif

			@if ($user->phone)
				<tr>
					<th>Телефон</th>
					<td>{{ $user->phone }}</td>
				</tr>
			@endif

			@if ($user->name)
				<tr>
					<th>Имя</th>
					<td>{{ $user->name }}</td>
				</tr>
			@endif

			@if ($user->city)
				<tr>
					<th>Город</th>
					<td>{{ $user->city }}</td>
				</tr>
			@endif

			@if ($user->site)
				<tr>
					<th>Сайт</th>
					<td>{{ $user->site }}</td>
				</tr>
			@endif

			@if ($user->icq)
				<tr>
					<th>ICQ</th>
					<td>{{ $user->icq }}</td>
				</tr>
			@endif

			@if ($user->skype)
				<tr>
					<th>Skype</th>
					<td>{{ $user->skype }}</td>
				</tr>
			@endif

			@if ($user->jabber)
				<tr>
					<th>Jabber</th>
					<td>{{ $user->jabber }}</td>
				</tr>
			@endif

			<tr>
				<th>Баллы</th>
				<td>{{ $user->point }}</td>
			</tr>

			<tr>
				<th>Деньги</th>
				<td>{{ $user->money }}</td>
			</tr>


			<tr>
				<th>Статус</th>
				<td>{{ $user->getStatus() }}</td>
			</tr>

			<tr>
				<th>Репутация</th>
				<td>{!! $user->getRating() !!} (+{{ $user->posrating }}/-{{ $user->negrating }})</td>
			</tr>

			@if ($user->info)
				<tr>
					<th>Информация</th>
					<td>{{ $user->info }}</td>
				</tr>
			@endif
		</tbody>
	</table>
@stop
