@extends('layout')

@section('title', 'Авторизация - @parent')

@section('content')

	<h1>Авторизация</h1>

	@if (isset($_SESSION['social']))
		<div class="bg-success padding">
			<img class="img-circle border" alt="photo" src="{{ $_SESSION['social']->photo }}" style="width: 48px; height: 48px;">
			<span class="label label-primary">{{ $_SESSION['social']->network }}</span> {{ $_SESSION['social']->first_name }} {{ $_SESSION['social']->last_name }} {{ isset($_SESSION['social']->nickname) ? '('.$_SESSION['social']->nickname.')' : '' }}
		</div>
		<div class="bg-info padding" style="margin-bottom: 30px;">
			Профиль не связан с какой-либо учетной записью на сайте. Войдите на сайт или зарегистирируйтесь, чтобы связать свою учетную запись с профилем социальной сети.<br>
			Или выберите другую социальную сеть для входа.
		</div>
	@endif

	<script src="//ulogin.ru/js/ulogin.js"></script>
	<div class="col-sm-offset-3" style="padding: 5px;" id="uLogin" data-ulogin="display=panel;fields=first_name,last_name,photo;optional=sex,email,nickname;providers=vkontakte,odnoklassniki,mailru,facebook,twitter,google,yandex;redirect_uri=http%3A%2F%2F{{ Setting::get('sitelink') }}%2Flogin">
	</div>

	<form class="form-horizontal" role="form" method="post">
		<div class="form-group">
			<label for="inputLogin" class="col-sm-3 control-label">Email / Логин</label>
			<div class="col-sm-5">
				<input name="login" type="text" class="form-control" id="inputLogin"  maxlength="50" placeholder="Email или Логин" value="{{ App::getInput('login') }}" required>
			</div>
		</div>
		<div class="form-group has-feedback">
			<label for="inputPassword" class="col-sm-3 control-label">Пароль</label>
			<div class="col-sm-5">
				<input name="password" type="password" class="form-control eye" id="inputPassword" maxlength="30" placeholder="Пароль" required>
				<span class="glyphicon glyphicon-eye-close form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<div class="checkbox">
					<label>
						<input name="remember" type="checkbox" checked="checked"> Запомнить меня
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<a class="btn btn-default" href="/recovery">Напомнить пароль</a>
				<button type="submit" class="btn btn-primary col-lg-offset-2 pull-right">Войти</button>
			</div>
		</div>
	</form>
@stop
