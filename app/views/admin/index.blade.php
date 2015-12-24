@extends('layout')

@section('title', 'Админ-панель - @parent')
@section('breadcrumbs', App::breadcrumbs(['Админ-панель']))

@section('content')

	<h1>Админпанель</h1>

	<div class="content-block">
		<div class="row">
			{{-- Гостевая книга --}}
			<div class="col-sm-6 col-lg-4">
				@include('admin._guest', ['count' => Guestbook::count()])
			</div>

			{{-- Форум --}}
			<div class="col-sm-6 col-lg-4">
				@include('admin._forum', ['topicCount' => Topic::count(), 'postCount' => Post::count()])
			</div>

			{{-- Новости --}}
			<div class="col-sm-6 col-lg-4">
				@include('admin._news', ['count' => News::count()])
			</div>

		</div>
	</div>

@stop
