<form class="well form-horizontal" role="form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

	<div class="form-group{{ App::hasError('name') }}">
		<label for="inputName" class="col-sm-2 control-label">Название <span class="required">*</span></label>
		<div class="col-sm-6">
			<input name="name" type="text" class="form-control" id="inputName"  maxlength="50" placeholder="Название категории" value="{{ App::getInput('name', $category->name) }}">
			{!! App::textError('name') !!}
		</div>
	</div>

	<div class="form-group{{ App::hasError('slug') }}">
		<label for="inputTitle" class="col-sm-2 control-label">Ссылка <span class="required">*</span></label>
		<div class="col-sm-6">
			<div class="help-block">Оставьте поле пустым  и ссылка сформируется автоматически</div>
			<input name="slug" type="text" class="form-control" id="inputSlug"  maxlength="50" placeholder="Ссылка категории" value="{{ App::getInput('slug', $category->slug) }}">
			{!! App::textError('slug') !!}
		</div>
	</div>

	<div class="form-group{{ App::hasError('description') }}">
		<label for="inputDescription" class="col-sm-2 control-label">Описание</label>
		<div class="col-sm-10">
			<textarea name="description" class="form-control" rows="5" id="inputDescription" placeholder="Описание">{{ App::getInput('description', $category->description) }}</textarea>
			{!! App::textError('description') !!}
		</div>
	</div>

	<div class="form-group{{ App::hasError('sort') }}">
		<label for="inputSort" class="col-sm-2 control-label">Сортировка</label>
		<div class="col-sm-2">
			<input name="sort" type="text" class="form-control" id="inputSort" maxlength="3" placeholder="Сортировка" value="{{ App::getInput('sort', isset($maxSort) ? $maxSort : $category->sort) }}">
			{!! App::textError('sort') !!}
		</div>
	</div>

	<div class="form-group{{ App::hasError('parent') }}">
		<label for="inputParent" class="col-sm-2 control-label">Родительская категория <span class="required">*</span></label>
		<div class="col-sm-5">
		<select class="form-control" id="inputParent" name="parent">
			<option value="0">Основная категория</option>
			<option value="111">Основная категория</option>
			@foreach ($categories as $data)
				@continue($data->id == $category->id)

				<?php $selected = ($data->id == App::getInput('parent', $category->parent_id)) ? ' selected' : ''; ?>
				<option value="{{ $data->id }}"{{ $selected }}>{{ $data->name }}</option>
			@endforeach

		</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-10 col-sm-2">
			<button type="submit" class="btn btn-primary pull-right">Сохранить</button>
		</div>
	</div>
</form>
