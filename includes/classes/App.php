<?php

class App
{
	/**
	 * Метод подключения шаблонов
	 * @param  string  $view   имя шаблона
	 * @param  array   $params массив параметров
	 * @param  boolean $return возвращать код иди записывать в переменную
	 * @return string сформированный код
	 */
	public static function render($view, $params = array(), $return = false){
		global $config, $current_user;

		extract($params);

		if ($return) {
			ob_start();
		}

		if (file_exists(BASEDIR.'/themes/'.$config['themes'].'/views/'.$view.'.php')){
			include (BASEDIR.'/themes/'.$config['themes'].'/views/'.$view.'.php');
		} elseif (file_exists(BASEDIR.'/themes/default/views/'.$view.'.php')){
			include (BASEDIR.'/themes/default/views/'.$view.'.php');
		} else {
			show_error('Не удалось найти требуемый шаблон "'.$view.'"');
		}

		if ($return) {
			return ob_get_clean();
		}
	}

	/**
	 * Limit the number of characters in a string.
	 *
	 * @param  string  $value
	 * @param  int     $limit
	 * @param  string  $end
	 * @return string
	 */
	public static function limit($value, $limit = 100, $end = '...')
	{
		if (mb_strlen($value) <= $limit) return $value;

		return rtrim(mb_substr($value, 0, $limit, 'UTF-8')).$end;
	}

	/**
	 * Convert the given string to lower-case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function lower($value)
	{
		return mb_strtolower($value);
	}

	/**
	 * Limit the number of words in a string.
	 *
	 * @param  string  $value
	 * @param  int     $words
	 * @param  string  $end
	 * @return string
	 */
	public static function words($value, $words = 100, $end = '...')
	{
		preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

		if ( ! isset($matches[0])) return $value;

		if (strlen($value) == strlen($matches[0])) return $value;

		return rtrim($matches[0]).$end;
	}
}
