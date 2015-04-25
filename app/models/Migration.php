<?php
class Migration extends BaseModel {

	static $table_name = 'migrations';
	static $operations = array();

	/**
	 *  Метод выполения миграций
	 * @param  string $name уникальное название миграции
	 * @return array массив списка результатов
	 */
	public static function migrate($name) {

		$migration = new self;
		$migration->migration = $name;
		$migration->save();

		self::$operations[] = "Миграция {$name} успешно выполнена\n";
	}

	/**
	 * Результат выполнения миграциии
	 * @return string текст результата и кол. операций
	 */
	public static function result() {
		if (count(self::$operations) > 0) {

			foreach (self::$operations as  $operation) {
				echo $operation;
			}

			echo "Всего операций: ".count(self::$operations)."\n";
		} else {
			echo "База данных не нуждается в обновлении!\n";
}
	}
}
