@extends('layout')

@section('title', 'Создание новости - @parent')
@section('breadcrumbs', App::breadcrumbs(['/news' => 'Новости сайта', 'Создание новости']))

@section('content')

	<h1>Создание новости</h1>

	<p class="bg-info padding">Поля отмеченные <span class="required">*</span> обязательны для заполнения</p>

	<form class="well form-horizontal" role="form" method="post" enctype="multipart/form-data">

		<div class="form-group{{ App::hasError('title') }}">
			<label for="inputTitle" class="col-sm-2 control-label">Заголовок <span class="required">*</span></label>
			<div class="col-sm-6">
				<input name="title" type="text" class="form-control" id="inputTitle"  maxlength="50" placeholder="Заголовок новости" value="{{ App::getInput('title') }}">
				{!! App::textError('title') !!}
			</div>
		</div>

		<div class="form-group{{ App::hasError('text') }}">
			<label for="markItUp" class="col-sm-2 control-label">Текст <span class="required">*</span></label>
			<div class="col-sm-10">
				<textarea name="text" class="form-control" rows="5" id="markItUp" placeholder="Текст новости">{{ App::getInput('text') }}</textarea>
				{!! App::textError('text') !!}
			</div>
		</div>

		<div class="form-group">
			<label for="inputImage" class="col-sm-2 control-label">Картинка</label>
			<div class="col-sm-10">
				<input type="file" name="image" accept="image/*" id="inputImage" title="Выберите файл">
				<p class="help-block">Разрешены файлы jpg, jpeg, gif, png</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-10 col-sm-2">
				<button type="submit" class="btn btn-primary pull-right">Сохранить</button>
			</div>
		</div>
	</form>
@stop
