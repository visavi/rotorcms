@extends('layout')

@section('title', 'Ошибка 403 - @parent')

@section('content')

	<div class="row">
		<div class="col-md-5 text-right">
			<img src="/assets/img/error403.png" alt="error 403" />
		</div>
		<div class="col-md-7">
			<h3>Ошибка 403!</h3>
			<div class="lead">Доступ запрещен!</div>
		</div>
	</div>
@stop
