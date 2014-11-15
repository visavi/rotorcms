<?php

class BaseActiveRecord extends ActiveRecord\Model
{
	/**
	 * Возвращает все ошибки в виде строки
	 * @param string $separator разделитель между ошибками
	 * @return string ошибки в виде строки
	 */
	public function getErrors($separator = '<br />') {
		if ($this->errors) {
			$result = array();
			$raw_errors = $this->errors->get_raw_errors();
			foreach ($raw_errors as $attribute => $errors) {
				foreach ($errors as $error) {
					$result[] = $error;
				}
			}
			return implode($separator, $result);
		}
		return false;
	}
}
