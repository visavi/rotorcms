@extends('layout')

@section('title', 'Регистрация - @parent')

@section('content')

	<h1>Регистрация</h1>

	@if (isset($_SESSION['social']))
		<div class="bg-success padding" style="margin-top: 20px;">
		<img class="img-circle border" alt="photo" src="{{ $_SESSION['social']->photo }}" style="width: 48px; height: 48px;">
			<span class="label label-primary">{{ $_SESSION['social']->network }}</span> {{ $_SESSION['social']->first_name }} {{ $_SESSION['social']->last_name }} {{ isset($_SESSION['social']->nickname) ? '('.$_SESSION['social']->nickname.')' : '' }}
		</div>
		<div class="bg-info padding" style="margin-bottom: 30px;">
			Профиль не связан с какой-либо учетной записью на сайте. Войдите на сайт или зарегистирируйтесь, чтобы связать свою учетную запись с профилем социальной сети.<br>
			Или выберите другую социальную сеть для входа.
		</div>
	@endif

	<script src="//ulogin.ru/js/ulogin.js"></script>
	<div class="col-sm-offset-3" style="padding: 10px 5px;" id="uLogin" data-ulogin="display=panel;fields=first_name,last_name,photo;optional=sex,email,nickname;providers=vkontakte,odnoklassniki,mailru,facebook,twitter,google,yandex;redirect_uri=http%3A%2F%2F{{ Setting::get('sitelink') }}%2Fregister">
	</div>

	<form class="form-horizontal" role="form" method="post">

		<div class="form-group{{ App::hasError('login') }}">
			<label for="inputLogin" class="col-sm-3 control-label">Логин</label>
			<div class="col-sm-5">
				<input name="login" type="text" class="form-control" id="inputLogin" maxlength="20" placeholder="Логин" value="{{ App::getInput('login', isset($_SESSION['social']->nickname) ? $_SESSION['social']->nickname : '') }}" required>
				{!! App::textError('login') !!}
			</div>
		</div>

		<div class="form-group has-feedback{{ App::hasError('password') }}">
			<label for="inputPassword" class="col-sm-3 control-label">Пароль</label>
			<div class="col-sm-5">
				<input name="password" type="password" class="form-control eye" id="inputPassword" maxlength="50" placeholder="Пароль" required>
				<span class="glyphicon glyphicon-eye-close form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
				{!! App::textError('password') !!}
				<span class="help-block">Минимальная длина пароля 6 символов</span>
			</div>
		</div>

		<div class="form-group{{ App::hasError('email') }}">
			<label for="inputEmail" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-5">
				<input name="email" type="text" class="form-control" id="inputEmail" maxlength="50" placeholder="Email" value="{{ App::getInput('email', isset($_SESSION['social']->email) ? $_SESSION['social']->email : '') }}" required>
				{!! App::textError('email') !!}
			</div>
		</div>

		<?php $sex = (isset($_SESSION['social']->sex) && $_SESSION['social']->sex == 1) ? 'female' : 'male'; ?>

 		<div class="form-group{{ App::hasError('gender') }}">
			<label for="inputGender" class="col-sm-3 control-label">Пол</label>
			<div class="col-sm-5">
				<input type="radio" name="gender" id="inputGenderMale" value="male"{{ (App::getInput('gender', $sex) == 'male' ? ' checked="checked"' : '') }}>
				<label for="inputGenderMale">Мужской</label>

				<input type="radio" name="gender" id="inputGenderFemale" value="female"{{ (App::getInput('gender', $sex) == 'female' ? ' checked="checked"' : '') }}>
				<label for="inputGenderFemale">Женский</label>
				{!! App::textError('gender') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('captcha') }}">
			<label for="inputCaptcha" class="col-sm-3 control-label">Проверочный код</label>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-6">
						<input name="captcha" type="text" class="form-control" id="inputCaptcha" maxlength="6" placeholder="Проверочный код" required>
					</div>
					<div class="col-sm-6">
						<img src="/captcha" id="captcha" onclick="this.src='/captcha?'+Math.random()" class="img-rounded" alt="" style="cursor: pointer;">
					</div>
				</div>
				{!! App::textError('captcha') !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
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
