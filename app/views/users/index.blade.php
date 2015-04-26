@extends('layout')

@section('title', 'Список пользователей - @parent')

@section('content')

	<h1>Список пользователей</h1>

	@if ($total)
		<table class="table table-hover table-striped" style="background-color: #fff;">
			<thead>
				<tr>
					<th>#</th>
					<th>ФИО</th>
					<th>Телефон</th>
					<th>E-mail</th>
					<th>Статус</th>
					<th>Дата регистрации</th>
					@if (User::isAdmin())
						<th class="bg-info">Действие</th>
					@endif
				</tr>
			</thead>

			<tbody>
				@foreach ($users as $user)
					<tr onclick="location.href='/user/{{ $user->id }}'" style="cursor:pointer">
						<td>{{ $user->id }}</td>
						<td>{{ $user->getFullName() }}</td>
						<td>{{ $user->getPhone() }}</td>
						<td>{{ $user->email }}</td>
						<td>{!! $user->getLevel() !!}</td>
						<td>{{ $user->created_at->format('d.m.Y, H:i') }}</td>

						@if (User::isAdmin())
							<td>
								<a href="/admin/users/edit/{{ $user->id }}" data-toggle="tooltip" title="Редактировать"><i class="fa fa-pencil"></i></a>

								<a href="/admin/users/delete/{{ $user->id }}?token={{ $_SESSION['token'] }}" data-toggle="tooltip" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');"><i class="fa fa-trash"></i></a>
							</td>
						@endif

					</tr>
				@endforeach
			</tbody>
		</table>

		{{ App::pagination(Setting::get('users_per_page'), $page, $total) }}

	@else
		<div class="alert alert-danger">Пользователей еще нет!</div>
	@endif
@stop
