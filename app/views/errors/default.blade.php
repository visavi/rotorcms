@extends('layout')

@section('title', 'Ошибка - @parent')

@section('content')

	<?php $images = glob(HOME.'/assets/img/errors/*.png'); ?>

	<div class="row">
		<div class="col-md-5 text-right">
			<img src="/assets/img/errors/{{ basename($images[array_rand($images)]) }}" alt="error 404" />
		</div>
		<div class="col-md-7">
			<h3>Ошибка!</h3>
			<div class="lead">{{ $message }}</div>
		</div>
	</div>
@stop
