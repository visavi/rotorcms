<?php

class BaseModel extends ActiveRecord\Model
{
	/**
	 * Возвращает все ошибки в виде строки
	 * @param string $separator разделитель между ошибками
	 * @return string ошибки в виде строки
	 */
	public function getErrors() {

		if ($this->errors->size()) {
			$result = array();
			$raw_errors = $this->errors->get_raw_errors();
			foreach ($raw_errors as $attribute => $errors) {
				foreach ($errors as $error) {
					$result[$attribute] = $error;
				}
			}

			return $result;
		}
		return false;
	}

	/**
	 * Подсвечивает текстовый блок красным цветом
	 * @param  string  $attribute имя поля
	 * @return string класс ошибки
	 */
	public function hasError($attribute)
	{
		if ($this->errors && $this->errors->is_invalid($attribute)) return ' has-error';
	}

	/**
	 * Выводит блок с текстом ошибки
	 * @param  string  $attribute имя поля
	 * @return string  блоки ошибки
	 */
	public function textError($attribute)
	{
		if ($this->errors && $this->errors->is_invalid($attribute)) {
			$error = $this->errors->on($attribute);
			return '<div class="text-danger">'.$error.'</div>';
		}
	}
}
