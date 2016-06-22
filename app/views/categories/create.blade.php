@extends('layout')

@section('title', 'Создание категории - @parent')
@section('breadcrumbs', App::breadcrumbs(['/admin' => 'Админ-панель', '/category' => 'Список категорий', 'Создание категории']))

@section('content')

	<h1>Создание категории</h1>

	<p class="bg-info padding">Поля отмеченные <span class="required">*</span> обязательны для заполнения</p>

	{{ App::view('categories._form', compact('category', 'categories', 'maxSort')) }}
@stop
