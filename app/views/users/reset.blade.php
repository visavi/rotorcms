@extends('layout')

@section('title', 'Сброс пароля - @parent')

@section('content')

	<h1>Сброс пароля</h1>

	<form class="form-horizontal" role="form" method="post">

		<div class="form-group has-feedback">
			<label for="inputPassword" class="col-sm-2 control-label">Новый пароль</label>
			<div class="col-sm-5">
				<input name="password" type="password" class="form-control eye" id="inputPassword" maxlength="30" placeholder="Пароль" required>
				<span class="glyphicon glyphicon-eye-close form-control-feedback reveal" style="cursor: pointer;" onclick="revealPassword(this);"></span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</form>
@stop
