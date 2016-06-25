<?php
class News extends BaseModel {

	static $table_name = 'news';

	static $has_many = [
		['comments', 'foreign_key' => 'relate_id', 'conditions' => ['relate_type = ?', 'news'], 'order' => 'created_at DESC'],
	];

	static $has_one = [
		['comment_count', 'foreign_key' => 'relate_id', 'conditions' => ['relate_type = ?', 'news'], 'select' => 'count(*) as count, relate_id', 'class' => 'Comment'],
	];

	static $belongs_to = [
		'category',
		'user',
	];

	static $validates_size_of = [
		['title', 'within' => [5, 50], 'too_short' => 'Слишком короткий заголовок, минимум %d симв.', 'too_long' => 'Слишком длинный заголовок, максимум %d симв.'],
		['text', 'minimum' => 5, 'too_short' => 'Слишком короткий текст новости, минимум %d симв.'],
	];

	static $validates_existence_of = [
		['category_id', 'in' => 'Category:id', 'message' => 'Категория новостей не найдена'],
	];


	/**
	 * Количество комментарий новости
	 * @return integer количество комментарий новости
	 */
	public function commentCount()
	{
		return $this->comment_count ? $this->comment_count->count : 0;
	}

	/**
	 * Данные пользователя
	 * @return object User модель пользователей
	 */
	public function user()
	{
		return $this->user ? $this->user : new User;
	}

	/**
	 * Обработка текста для RSS-ленты
	 * @return string обработанный текст новости
	 */
	public function textRssFormat()
	{
		$this->text = App::bbCode($this->text);
		$this->text = preg_replace('/\r\n|\r|\n|\s+/u', ' ', $this->text);
		$this->text = str_replace('<img src="', '<img src="http://'.Setting::get('sitelink'), $this->text);

		return $this->text;
	}

	/**
	 * Метод вызываемый после сохранения
	 */
	public function after_save()
	{
		$slug = App::slugify($this->title);
		$this->slug = $this->id.'-'.$slug;
		$this->save();
	}
}
