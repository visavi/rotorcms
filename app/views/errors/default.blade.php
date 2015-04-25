@extends('layout')

@section('title', 'Ошибка - @parent')

@section('content')

	<div class="row">
		<div class="col-md-5 text-right">
			<img src="/assets/img/error.png" alt="error" />
		</div>
		<div class="col-md-7">
			<h3>Ошибка!</h3>
			<div class="lead">{{ $message }}</div>
		</div>
	</div>
@stop
