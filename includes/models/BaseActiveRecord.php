<?php

class BaseActiveRecord extends ActiveRecord\Model
{
	/**
	 * Метод атрибутов полей
	 * @return array пустой массив
	 */
/*	public function attributeLabels() {
		return array();
	}*/

	/**
	 * Возвращает все ошибки в виде строки
	 * @param string $separator разделитель между ошибками
	 * @return string ошибки в виде строки
	 */
	public function getErrors($separator = '<br />') {
		$result = array();
		//$labels = $this->attributeLabels();
		$raw_errors = $this->errors->get_raw_errors();

		foreach ($raw_errors as $attribute => $errors) {
			foreach ($errors as $error) {
				//$result[] = (isset($labels[$attribute]) ? $labels[$attribute] : ActiveRecord\Utils::human_attribute($attribute)).' '.$error;
				$result[] = $error;
			}
		}
		return implode($separator, $result);
	}
}
