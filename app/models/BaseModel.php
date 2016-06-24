<?php

class BaseModel extends ActiveRecord\Model
{
	/**
	 * Возвращает все ошибки в виде массива
	 * @return array Список ошибок
	 */
	public function getErrors()
	{
		if ($this->errors && $this->errors->size()) {
			$result = [];
			$raw_errors = $this->errors->get_raw_errors();
			foreach ($raw_errors as $attribute => $errors) {
				foreach ($errors as $error) {
					$result[$attribute] = $error;
				}
			}

			return $result;
		}
		return [];
	}

	/**
	 * Сокращенный вывод ошибок
	 * @return string список ошибок
	 */
	public function getErrorsText()
	{
		$result = [];
		foreach ($this->getErrors() as $error) {
			$result[] = $error;
		}

		return implode('<br />', $result);
	}

	/**
	 * Подсвечивает текстовый блок красным цветом
	 * @param  string $attribute имя поля
	 * @return string CSS-класс ошибки
	 */
	public function hasError($attribute)
	{
		if ($this->errors && $this->errors->is_invalid($attribute)) return ' has-error';
	}

	/**
	 * Выводит блок с текстом ошибки
	 * @param  string $attribute имя поля
	 * @return string Блоки ошибки
	 */
	public function textError($attribute)
	{
		if ($this->errors && $this->errors->is_invalid($attribute)) {
			$error = $this->errors->on($attribute);
			return '<div class="text-danger">'.$error.'</div>';
		}
	}
}
