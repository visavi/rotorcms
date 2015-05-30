@extends('layout')

@section('title', 'Восстановление пароля - @parent')
@section('breadcrumbs', App::breadcrumbs(['Восстановление пароля']))

@section('content')

	<h1>Восстановление пароля</h1>

	<form class="form-horizontal" role="form" method="post">

		<div class="form-group{{ App::hasError('email') }}">
			<label for="inputEmail" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-5">
				<input name="email" type="text" class="form-control" id="inputEmail" maxlength="50" placeholder="Email" value="{{ App::getInput('email') }}" required>
				{!! App::textError('email') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('captcha') }}">
			<label for="inputCaptcha" class="col-sm-3 control-label">Проверочный код</label>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-6">
						<input name="captcha" type="text" class="form-control" id="inputCaptcha" maxlength="6" placeholder="Проверочный код" required>
					</div>
					<div class="col-sm-5">
						<img src="/captcha" onclick="this.src='/captcha?'+Math.random()" class="img-rounded" alt="" style="cursor: pointer;" />
					</div>
				</div>
				{!! App::textError('captcha') !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<button type="submit" class="btn btn-primary">Восстановить</button>
			</div>
		</div>
	</form>
@stop
