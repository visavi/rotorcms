<?php
class Setting extends BaseModel {

	static $table_name = 'settings';

	/**
	 * Получение настроек
	 * @param  string $key Имя настройки
	 * @return string Значение настройки
	 */
	public static function get($key)
	{
		if (!Registry::has('setting')) {
			Registry::set('setting', App::arrayAssoc(self::all(), 'name', 'value'));
		}

		return Registry::get('setting')[$key];
	}
}
