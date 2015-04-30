@extends('layout')

@section('title', 'Изменение пароля - @parent')
@section('breadcrumbs', App::breadcrumbs(['/users' => 'Пользователи', '/user/'.$user->login => $user->login, 'Изменение пароля']))

@section('content')

	<h1>Изменение пароля</h1>

	<form class="form-horizontal" role="form" method="post">

		<div class="form-group has-feedback{{ App::hasError('old_password') }}">
			<label for="inputOldPassword" class="col-sm-2 control-label">Старый пароль</label>
			<div class="col-sm-5">
				<input name="old_password" type="password" class="form-control eye" id="inputOldPassword" maxlength="50" placeholder="Старый пароль" required>
				<span class="glyphicon glyphicon-eye-close form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
				{!! App::textError('old_password') !!}
			</div>
		</div>

		<div class="form-group has-feedback{{ App::hasError('new_password') }}">
			<label for="inputNewPassword" class="col-sm-2 control-label">Новый пароль</label>
			<div class="col-sm-5">
				<input name="new_password" type="password" class="form-control eye" id="inputNewPassword" maxlength="50" placeholder="Новый пароль" required>
				<span class="glyphicon glyphicon-eye-close form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
				{!! App::textError('new_password') !!}
				<span class="help-block">Минимальная длина пароля 6 символов</span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-primary">Редактировать</button>
			</div>
		</div>
	</form>

@stop
