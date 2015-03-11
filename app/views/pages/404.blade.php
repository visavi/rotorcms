{{ header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found'); }}
@extends('layout')

@section('title', 'Ошибка 404 - @parent')

@section('content')

	<?php $images = glob(PUBLICDIR.'/assets/img/errors/*.png'); ?>

	<div class="row">
		<div class="col-md-5 text-right">
			<img src="/assets/img/errors/{{ basename($images[array_rand($images)]) }}" alt="error 404" />
		</div>
		<div class="col-md-7">
			<h3>Ошибка 404!</h3>
			<div class="lead">Такой страницы не существует!</div>
		</div>
	</div>
@stop
