<?php
class Category extends BaseModel {

	/**
	 * Список всех разделов
	 * @return array ассоциативный массив разделов
	 */
	public static function getAll()
	{
		return self::all(['conditions' => ['parent_id = ?', 0], 'order' => 'sort']);

		//return App::arrayAssoc($forums, 'id', 'title');
	}
}
