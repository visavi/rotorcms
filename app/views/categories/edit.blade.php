@extends('layout')

@section('title', 'Редактирование категории - @parent')
@section('breadcrumbs', App::breadcrumbs(['/admin' => 'Админ-панель', '/category' => 'Категории', 'Редактирование категории']))

@section('content')

	<h1>Редактирование категории</h1>

	{{ App::view('categories._form', compact('category', 'categories')) }}
@stop
