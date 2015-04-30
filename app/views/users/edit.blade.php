@extends('layout')

@section('title', 'Редактирование профиля - @parent')
@section('breadcrumbs', App::breadcrumbs(['/users' => 'Пользователи', '/user/'.User::get('login') => User::get('login'), 'Редактирование']))

@section('content')

	<h1>Редактирование профиля</h1>

	<form class="form-horizontal" role="form" method="post">

		<p class="help-block">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

		<input name="token" type="hidden" value="{{ $_SESSION['token'] }}">

		<div class="form-group{{ App::hasError('email') }}">
			<label for="inputEmail" class="col-sm-3 control-label">Email <span class="required">*</span></label>
			<div class="col-sm-5">
				<input name="email" type="text" class="form-control" id="inputEmail"  maxlength="50" placeholder="Email" value="{{ App::getInput('email', $user->email) }}" required>
				{!! App::textError('email') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('gender') }}">
			<label for="inputGender" class="col-sm-3 control-label">Пол</label>
			<div class="col-sm-5">
				<input type="radio" name="gender" id="inputGenderMale" value="male"{{ (App::getInput('gender', $user->gender) == 'male' ? ' checked="checked"' : '') }}>
				<label for="inputGenderMale">Мужской</label>

				<input type="radio" name="gender" id="inputGenderFemale" value="female"{{ (App::getInput('gender', $user->gender) == 'female' ? ' checked="checked"' : '') }}>
				<label for="inputGenderFemale">Женский</label>
				{!! App::textError('gender') !!}
			</div>
		</div>

		@if (User::isAdmin())
			<div class="form-group bg-info{{ App::hasError('level') }}" style="padding: 10px 0;">
				<label for="inputLevel" class="col-sm-3 control-label">Статус</label>
				<div class="col-sm-5">
				<select class="form-control" id="inputLevel" name="level">

					@foreach (User::$levelList as $key => $level)
						<?php $selected = ($key ==  App::getInput('level', $user->level)) ? ' selected' : ''; ?>
						<option value="{{ $key }}"{{ $selected }}>{!! $level !!}</option>
					@endforeach

				</select>
				</div>
			</div>
		@endif

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-primary">Редактировать</button>
			</div>
		</div>
	</form>

@stop
