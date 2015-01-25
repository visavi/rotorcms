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
}
