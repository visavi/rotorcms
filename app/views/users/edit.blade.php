@extends('layout')

@section('title', 'Редактирование профиля - @parent')

@section('content')

	<h1>Редактирование профиля</h1>

	<form class="form-horizontal" role="form" method="post">

		<p class="help-block">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

		<input name="token" type="hidden" value="{{ $_SESSION['token'] }}">

		<div class="form-group{{ App::hasError('email') }}">
			<label for="inputEmail" class="col-sm-2 control-label">Email <span class="required">*</span></label>
			<div class="col-sm-5">
				<input name="email" type="text" class="form-control" id="inputEmail"  maxlength="50" placeholder="Email" value="{{ App::getInput('email', $user->email) }}" required>
				{!! App::textError('email') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('first_name') }}">
			<label for="inputFirstName" class="col-sm-2 control-label">Имя <span class="required">*</span></label>
			<div class="col-sm-5">
				<input name="first_name" type="text" class="form-control" id="inputFirstName"  maxlength="50" placeholder="Имя" value="{{ App::getInput('first_name', $user->first_name) }}" required>
				{!! App::textError('first_name') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('last_name') }}">
			<label for="inputLastName" class="col-sm-2 control-label">Фамилия</label>
			<div class="col-sm-5">
				<input name="last_name" type="text" class="form-control" id="inputLastName"  maxlength="50" placeholder="Фамилия" value="{{ App::getInput('last_name', $user->last_name) }}">
				{!! App::textError('last_name') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('middle_name') }}">
			<label for="inputMiddleName" class="col-sm-2 control-label">Отчество</label>
			<div class="col-sm-5">
				<input name="middle_name" type="text" class="form-control" id="inputMiddleName"  maxlength="50" placeholder="Отчество" value="{{ App::getInput('middle_name', $user->middle_name) }}">
				{!! App::textError('middle_name') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('phone') }}">
			<label for="inputPhone" class="col-sm-2 control-label">Телефон <span class="required">*</span></label>
			<div class="col-sm-5">
				<input name="phone" type="text" class="form-control phone" id="inputPhone" placeholder="+7 (900) 123-45-67" value="{{ App::getInput('phone', $user->phone) }}" required>
				{!! App::textError('phone') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('company_name') }}">
			<label for="inputCompanyName" class="col-sm-2 control-label">Название компании</label>
			<div class="col-sm-5">
				<input name="company_name" type="text" class="form-control" id="inputCompanyName"  maxlength="50" placeholder="Название компании" value="{{ App::getInput('company_name', $user->company_name) }}">
				{!! App::textError('company_name') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('company_address') }}">
			<label for="inputCompanyIndex" class="col-sm-2 control-label">Адрес</label>
			<div class="col-sm-5">
				<input name="company_address" type="text" class="form-control" id="inputCompanyIndex"  maxlength="250" placeholder="Адрес" value="{{ App::getInput('company_address', $user->company_address) }}">
				{!! App::textError('company_address') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('company_inn') }}">
			<label for="inputCompanyInn" class="col-sm-2 control-label">ИНН</label>
			<div class="col-sm-5">
				<input name="company_inn" type="text" class="form-control" id="inputCompanyInn"  maxlength="10" placeholder="ИНН" value="{{ App::getInput('company_inn', $user->company_inn) }}">
				{!! App::textError('company_inn') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('company_kpp') }}">
			<label for="inputCompanyKpp" class="col-sm-2 control-label">КПП</label>
			<div class="col-sm-5">
				<input name="company_kpp" type="text" class="form-control" id="inputCompanyKpp"  maxlength="9" placeholder="КПП" value="{{ App::getInput('company_kpp', $user->company_kpp) }}">
				{!! App::textError('company_kpp') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('company_ogrn') }}">
			<label for="inputCompanyOgrn" class="col-sm-2 control-label">ОГРН</label>
			<div class="col-sm-5">
				<input name="company_ogrn" type="text" class="form-control" id="inputCompanyOgrn"  maxlength="13" placeholder="ОГРН" value="{{ App::getInput('company_ogrn', $user->company_ogrn) }}">
				{!! App::textError('company_ogrn') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('info') }}">
			<label for="inputInfo" class="col-sm-2 control-label">Информация</label>
			<div class="col-sm-5">
				<textarea name="info" class="form-control" rows="5" id="inputInfo" placeholder="Информация">{{ App::getInput('info', $user->info) }}</textarea>
				{!! App::textError('info') !!}
			</div>
		</div>

		@if (User::isAdmin())
			<div class="form-group bg-info{{ App::hasError('level') }}" style="padding: 10px 0;">
				<label for="inputLevel" class="col-sm-2 control-label">Статус</label>
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
