@extends('layout')

@section('title', 'Список категорий - @parent')
@section('breadcrumbs', App::breadcrumbs(['/admin' => 'Админ-панель', 'Список категорий']))

@section('content')

	<div class="pull-right">
		<a href="/category/create" class="btn btn-sm btn-primary">Создать категорию</a>
	</div>

	<h1>Список категорий</h1>

	@if ($categories)

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
				<tr class="js-record">
					<td>{{ $category->sort }}</td>
					<td><strong><a href="{{ $category->slug }}">{{ $category->name }}</a></strong></td>
					<td>{{ $category->slug }}</td>
					<td class="text-center">
						<a href="/category/{{ $category->id }}/edit"><i class="fa fa-edit"></i></a>
						@if (! $category->children)
							<a href="#" onclick="return deleteRecord(this, '/category/delete')" data-type="guest" data-id="{{ $category->id }}" data-token="{{ $_SESSION['token'] }}"><i class="fa fa-trash"></i></a>
						@else
							<i class="fa fa-trash"></i>
						@endif
					</td>
				</tr>

				@if ($category->children)
					@foreach ($category->children as $subcategory)
						<tr class="info js-record">
							<td>{{ $subcategory->sort }}</td>
							<td><a href="{{ $subcategory->slug }}">{{ $subcategory->name }}</a></td>
							<td>{{ $subcategory->slug }}</td>
							<td class="text-center"><a href="/category/{{ $subcategory->id }}/edit"><i class="fa fa-edit"></i></a> <a onclick="return deleteRecord(this, '/category/delete')" data-type="guest" data-id="{{ $subcategory->id }}" data-token="{{ $_SESSION['token'] }}"><i class="fa fa-trash"></i></a></td>
						</tr>
					@endforeach
				@endif

			@endforeach
		</tbody>
	</table>

	@else
		<div class="alert alert-danger">Категории новостей еще не созданы!</div>
	@endif
@stop
