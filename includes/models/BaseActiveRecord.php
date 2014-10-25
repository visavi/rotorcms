<?php
class BaseActiveRecord extends ActiveRecord\Model {

	/**
	 * Возвращает все ошибки в виде строки
	 * @param string $separator разделитель между ошибками
	 * @return string ошибки в виде строки
	 */
	public function getErrors($separator = ', ') {
		$res = array();
		$fields = $this->errors->get_raw_errors();
		foreach ($fields as $errors) {
			foreach ($errors as $error) {
				$res[] = $error;
			}
		}
		return implode($separator, $res);
	}
}
