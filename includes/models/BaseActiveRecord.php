<?php
class BaseActiveRecord extends ActiveRecord\Model {

	/**
	 * Возвращает все ошибки в виде строки
	 * @param string $separator разделитель между ошибками
	 * @return string ошибки в виде строки
	 */
	public function getErrors($separator = '<br />') {
		$res = array();
		$labels = $this->attributeLabels();
		$raw_errors = $this->errors->get_raw_errors();

		foreach ($raw_errors as $field => $errors) {
			foreach ($errors as $error) {
				$res[] = isset($labels[$field]) ? $labels[$field].' '.$error : $field.' '.$error;
			}
		}
		return implode($separator, $res);
	}
}
