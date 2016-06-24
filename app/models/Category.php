<?php
class Category extends BaseModel {

	public $token;

	/**
	 * Связи
	 */
	static $has_many = [
		['news', 'order' => 'created_at DESC'],
		['children', 'foreign_key' => 'parent_id', 'order' => 'sort DESC', 'class' => 'Category'],
	];

	static $belongs_to = [
		['parent', 'foreign_key' => 'parent_id', 'class' => 'Category'],
	];

	static $has_one = [
		['news_count', 'select' => 'count(*) as count, category_id', 'group' => 'category_id', 'class' => 'News'],
	];

	/**
	 * Правила валидации
	 */
	static $validates_size_of = [
		['name', 'within' => [5, 50], 'too_short' => 'Слишком короткое название, минимум %d симв.', 'too_long' => 'Слишком длинное название, максимум %d симв.'],
		['slug', 'within' => [5, 50], /*'allow_blank' => true,*/ 'too_short' => 'Слишком короткая ссылка, минимум %d симв.', 'too_long' => 'Слишком длинная ссылка, максимум %d симв.'],
	];

 	static $validates_numericality_of = [
		['sort', 'only_integer' => true, 'greater_than_or_equal_to' => 0, 'message' => 'Необходимо целое число'],
	];

	static $validates_format_of = [
		['slug', 'with' => '/^[a-z0-9_\-]*$/', 'message' => 'Неверный формат ссылки, разрешены латинские символы и цифры'],
	];

	static $validates_existence_of = [
		['parent_id', 'in' => 'category:id', 'allow_empty' => true, 'message' => 'Родительская категория не найдена'],
	];

	static $validates_uniqueness_of = [
		['slug', 'message' => 'Ссылка на категорию должна быть уникальной'],
	];

	public function validate()
	{
		if ($this->token && $this->token !== $_SESSION['token']) {
			$this->errors->add('token', 'Неверный идентификатор сессии, повторите действие!');
		}
	}

	/**
	 * Список всех разделов
	 * @return array ассоциативный массив разделов
	 */
	public static function getAll()
	{
		return self::all(['conditions' => ['parent_id = ?', 0], 'order' => 'sort']);
	}

	/**
	 * Установки ссылки на категорию
	 */
	public function set_slug($slug)
	{
		if (empty($slug)) {
			$slug = App::slugify($this->name);
		}

		$this->assign_attribute('slug', $slug);
	}

	/**
	 * Метод вызываемый перед удалением
	 */
	public function before_destroy()
	{
		if (self::exists(['parent_id' => $this->id])) {
			$this->errors->add('parent_id', 'Запрещено удалять категории имеющие подкатегории!'.$this->parent_id);
			return false;
		}
	}
}
