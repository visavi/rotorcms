@extends('layout')

@section('title', 'Регистрация - @parent')

@section('content')

	<h1>Регистрация</h1>

	<form class="form-horizontal" role="form" method="post">

		<div class="form-group{{ App::hasError('email') }}">
			<label for="inputEmail" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-5">
				<input name="email" type="text" class="form-control" id="inputEmail" maxlength="50" placeholder="Email" value="{{ App::getInput('email') }}" required>
				{!! App::textError('email') !!}
			</div>
		</div>

		<div class="form-group has-feedback{{ App::hasError('password') }}">
			<label for="inputPassword" class="col-sm-2 control-label">Пароль</label>
			<div class="col-sm-5">
				<input name="password" type="password" class="form-control eye" id="inputPassword" maxlength="50" placeholder="Пароль" required>
				<span class="glyphicon glyphicon-eye-close form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
				{!! App::textError('password') !!}
				<span class="help-block">Минимальная длина пароля 6 символов</span>
			</div>
		</div>

		<div class="form-group{{ App::hasError('first_name') }}">
			<label for="inputFirstName" class="col-sm-2 control-label">Имя</label>
			<div class="col-sm-5">
				<input name="first_name" type="text" class="form-control" id="inputFirstName" maxlength="50" placeholder="Имя" value="{{ App::getInput('first_name') }}" required>
				{!! App::textError('first_name') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('phone') }}">
			<label for="inputPhone" class="col-sm-2 control-label">Телефон</label>
			<div class="col-sm-5">
				<input name="phone" type="text" class="form-control phone" id="inputPhone" placeholder="+7 (900) 123-45-67" value="{{ App::getInput('phone') }}" required>
				{!! App::textError('phone') !!}
			</div>
		</div>

{{-- 		<div class="form-group{{ App::hasError('gender') }}">
			<label for="inputGender" class="col-sm-2 control-label">Пол</label>
			<div class="col-sm-5">
				<input type="radio" name="gender" id="inputGenderMale" value="male"{{ (App::getInput('gender') == 'male' ? ' checked="checked"' : '') }}>
				<label for="inputGenderMale">Мужской</label>

				<input type="radio" name="gender" id="inputGenderFemale" value="female"{{ (App::getInput('gender') == 'female' ? ' checked="checked"' : '') }}>
				<label for="inputGenderFemale">Женский</label>
				{!! App::textError('gender') !!}
			</div>
		</div> --}}

		<div class="form-group{{ App::hasError('captcha') }}">
			<label for="inputCaptcha" class="col-sm-2 control-label">Проверочный код</label>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-7">
						<input name="captcha" type="text" class="form-control" id="inputCaptcha" maxlength="6" placeholder="Проверочный код" required>
					</div>
					<div class="col-sm-5">
						<img src="/captcha" id="captcha" onclick="this.src='/captcha?'+Math.random()" class="img-rounded" alt="" style="cursor: pointer;" /> <span style="border-bottom: 1px dashed #f00; color: #f00; cursor: pointer;" onclick="document.getElementById('captcha').src='/captcha?'+Math.random()">Обновить</span>
					</div>
				</div>
				{!! App::textError('captcha') !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-primary">Регистрация</button>
			</div>
		</div>
	</form>

	<div class="bg-info padding">
		Обновите страницу если вы не видите проверочный код!<br />
		Все поля обязательны для заполнения, более полную информацию о себе вы можете добавить в своем профиле после регистрации<br />
		Указывайте верный email, на него будут высланы регистрационные данные
	</div>
@stop
