@extends('layout')

@section('title', 'Список категорий - @parent')
@section('breadcrumbs', App::breadcrumbs(['/admin' => 'Админ-панель', 'Список категорий']))

@section('content')
	<div class="pull-right">
		<a href="/category/create" class="btn btn-sm btn-primary">Создать категорию</a>
	</div>


	<h1>Список категорий</h1>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Сорт.</th>
			<th>Название</th>
			<th>Ссылка</th>
			<th>Действие</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($categories as $category)
			<tr>
				<td>{{ $category->sort }}</td>
				<td>{{ $category->name }}</td>
				<td>{{ $category->slug }}</td>
				<td><a href="/category/{{ $category->id }}/edit"><i class="fa fa-edit"></i></a> <a href="/category/{{ $category->id }}/delete?token={{ $_SESSION['token'] }}"><i class="fa fa-trash"></i></a></td>
			</tr>
		@endforeach
	</tbody>
</table>

@stop
