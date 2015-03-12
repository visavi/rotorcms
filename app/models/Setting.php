<?php
class Setting extends BaseActiveRecord {

	static $table_name = 'setting';

	/**
	 * Получение настроек
	 * @param  string $key Имя настройки
	 * @return string Значение настройки
	 */
	public static function get($key)
	{
		if (!Registry::has('setting')) {
			Registry::set('setting', App::assoc(self::all(), 'name', 'value'));
		}

		return Registry::get('setting')[$key];
	}
}
