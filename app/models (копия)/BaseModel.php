<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent
{
	/**
	 * Возвращает все ошибки в виде строки
	 * @return array Список ошибок
	 */
	public function getErrors() {

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
