<?php
class Setting extends BaseActiveRecord {

	static $table_name = 'setting';

	/**
	 * Получение настроек
	 * @param  string $name Имя настройки
	 * @return string Значение настройки
	 */
	public static function get($name) {
		$setting = self::all();

		$setting = ActiveRecord\assoc($setting, 'name', 'value');

		return isset($setting[$name]) ? $setting[$name] : '';
	}
}
