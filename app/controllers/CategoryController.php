<?php

Class CategoryController Extends BaseController {

	/**
	 * Список категорий
	 */
	public function index()
	{
		if (!User::isAdmin()) App::abort('403');

		$categories = Category::all(['order' => 'sort']);

		App::view('categories.index', compact('categories'));
	}

	/**
	 * Создание категории
	 */
	public function create()
	{
		if (!User::isAdmin()) App::abort('403');

		$category = new Category();

		if (Request::isMethod('post')) {

			$category->token = Request::input('token', true);
			$category->parent_id = Request::input('parent');
			$category->name = Request::input('name');
			$category->slug = Request::input('slug');
			$category->description = Request::input('description');
			$category->sort = Request::input('sort');

			if ($category->save()) {
				App::setFlash('success', 'Категория успешно создана!');
				App::redirect('/category');
			} else {
				App::setFlash('danger', $category->getErrors());
				App::setInput($_POST);
			}
		}

		$maxSort = Category::find(['select' => 'max(sort) max']);
		$maxSort = $maxSort->max + 1;

		$categories = Category::getAll();
		App::view('categories.create', compact('category', 'categories', 'maxSort'));
	}

	/**
	 * Создание категории
	 */
	public function edit($id)
	{
		if (! User::isAdmin()) App::abort('403');
		if (! $category = Category::find_by_id($id)) App::abort('default', 'Категория не найдена!');

		if (Request::isMethod('post')) {

			$category->token = Request::input('token', true);
			$category->parent_id = Request::input('parent');
			$category->name = Request::input('name');
			$category->slug = Request::input('slug');
			$category->description = Request::input('description');
			$category->sort = Request::input('sort');

			if ($category->save()) {
				App::setFlash('success', 'Категория успешно изменена!');
				App::redirect('/category');
			} else {
				App::setFlash('danger', $category->getErrors());
				App::setInput($_POST);
			}
		}

		$categories = Category::getAll();
		App::view('categories.edit', compact('category', 'categories'));
	}

	/**
	 * Удаление категории
	 */
	public function delete($id)
	{
		if (! User::isAdmin()) App::abort(403);
		if (! $category = Category::find_by_id($id)) App::abort('default', 'Категория не найдена!');

		$category->token = Request::input('token', true);

		if ($category->is_valid()) {

			$category->delete();
			App::setFlash('success', 'Категория успешно удалена!');
		} else {
			App::setFlash('danger', $category->getErrors());
		}

		App::redirect('/category');
	}
}
