<?php
class App
{
	/**
	 * Данные роутов
	 * @return object данные роутов
	 */
	public static function router($key)
	{
		if (Registry::has('router')) {
			return Registry::get('router')[$key];
		}
	}

	/**
	 * Получает текущую страницу
	 * @return string текущая страница
	 */
	public static function requestUrl()
	{
		return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
	}

	/**
	 * Получает текущий метод запроса
	 * @return string текущий метод запроса
	 */
	public static function requestMethod()
	{
		return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
	}

	/**
	 * Метод подключения шаблонов
	 * @param  string  $view   имя шаблона
	 * @param  array $params массив параметров
	 * @return string сформированный код
	 */
	public static function view($view, $params = [], $return = false)
	{
		$blade = new Blade(APP.'/views', STORAGE.'/cache');

		if ($return) {
			return $blade->view()->make($view, $params);
		} else {
			echo $blade->view()->make($view, $params);
		}
	}

	/**
	 * Метод вывода страницы с ошибками
	 * @param integer $code код ошибки
	 * @param  string $message текст ошибки
	 * @return сформированная страница с ошибкой
	 */
	public static function abort($code, $message = '')
	{
		if ($code == 404) {
			header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
		}

		App::view('pages.'.$code, compact('message'));
	}

	/**
	 * Постраничная навигация
	 * @param  string  $url путь для формирования ссылки
	 * @param  integer  $rpp количество элементов на странице
	 * @param  integer  $current текущая страница
	 * @param  integer  $total общее количество элементов
	 * @param  integer $crumbs количество кнопок справа и слева
	 * @return string  сформированный блок с кнопками страниц
	 */
	public static function pagination($url, $rpp, $current, $total, $crumbs = 3)
	{
		if ($total > 0) {
			$request = null;
			if (($strpos = strpos($url, '?')) !== false) {
				$request = substr($url, $strpos);
				$url = substr($url, 0, $strpos);
			}

			$pages = [];
			$pg_cnt = ceil($total / $rpp);
			$idx_fst = max($current - $crumbs, 1);
			$idx_lst = min($current + $crumbs, $pg_cnt);

			if ($current != 1) {
				$pages[] = [
					'start' => $current - 1,
					'title' => 'Предыдущая',
					'name' => '«',
				];
			}
			if (($current - $idx_fst) >= 0) {
				if ($current > ($crumbs + 1)) {
					$pages[] = [
						'start' => 1,
						'title' => '1 страница',
						'name' => 1,
					];
					if ($current != ($crumbs + 2)) {
						$pages[] = [
							'separator' => true,
							'name' => ' ... ',
						];
					}
				}
			}

			for ($i = $idx_fst; $i <= $idx_lst; $i++) {

				if ($i == $current) {
					$pages[] = [
						'current' => true,
						'name' => $i,
					];
				} else {
					$pages[] = [
						'start' => $i,
						'title' => $i.' страница',
						'name' => $i,
					];
				}
			}
			if (($current + $idx_lst) < $total) {
				if ($current < ($pg_cnt - $crumbs)) {
					if ($current != ($pg_cnt - $crumbs - 1)) {
						$pages[] = [
							'separator' => true,
							'name' => ' ... ',
						];
					}
					$pages[] = [
						'start' => $pg_cnt,
						'title' => $pg_cnt . ' страница',
						'name' => $pg_cnt,
					];
				}
			}
			if ($current != $pg_cnt) {
				$pages[] = [
					'start' => $current + 1,
					'title' => 'Следующая',
					'name' => '»',
				];
			}

			self::view('includes/pagination', compact('pages', 'url'));
		}
	}

	/**
	 * Функция экранирование небезопасных символов
	 * @param  string|array $value строка или массив
	 * @return string|array обработанный текст
	 */
	public static function check($value)
	{
		if (is_array($value)) {
			foreach($value as $key => $val) {
				$value[$key] = check($val);
			}
		} else {

			$value = htmlspecialchars(stripslashes(trim($value)), ENT_QUOTES, 'UTF-8');

			$search = array("\0", "\x00", "\x1A", chr(226).chr(128).chr(174));

			$value = str_replace($search, '', $value);
		}

		return $value;
	}

	/**
	 * Метод переадресации
	 * @param  string  $url адрес переадресации
	 * @param  boolean $permanent постоянное перенаправление
	 */
	public static function redirect($url, $permanent = false)
	{
		if ($permanent){
			header('HTTP/1.1 301 Moved Permanently');
		}
		if (isset($_SESSION['captcha'])) unset($_SESSION['captcha']);

		exit(header('Location: '.$url));
	}

	/**
	 * Запись flash уведомления
	 * @param string $status статус уведомления
	 * @param array $message массив с уведомлениями
	 */
	public static function setFlash($status, $message)
	{
		$_SESSION['flash'][$status] = $message;
	}

	/**
	 * Вывод flash уведомления
	 * @param  array $errors массив уведомлений
	 * @return string сформированный блок с уведомлениями
	 */
	public static function getFlash()
	{
		self::view('app/flash');
	}

	/**
	 * Запись POST данных введенных пользователем
	 * @param array $data массив полей
	 */
	public static function setInput($data)
	{
		$_SESSION['input'] = $data;
	}

	/**
	 * Вывод значения из POST данных
	 * @param string $name имя поля
	 * @return string сохраненный текст
	 */
	public static function getInput($name, $default = '')
	{
		return isset($_SESSION['input'][$name]) ? $_SESSION['input'][$name] : $default;
	}

	/**
	 * Подсветка блока с полем для ввода сообщения
	 * @param string $field имя поля
	 * @return string CSS класс ошибки
	 */
	public static function hasError($field)
	{
		return isset($_SESSION['flash']['danger'][$field]) ? ' has-error' : '';
	}

	/**
	 * Выводит блок с текстом ошибки
	 * @param  string $field имя поля
	 * @return string блоки ошибки
	 */
	public static function textError($field)
	{
		if (isset($_SESSION['flash']['danger'][$field])) {
			$error = $_SESSION['flash']['danger'][$field];
			return '<div class="text-danger">'.$error.'</div>';
		}
	}

	/**
	 * Проверяет является ли email валидным
	 * @param  string  $email адрес email
	 * @return boolean результат проверки
	 */
	public static function isEmail($email)
	{
		return preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#', $email);
	}

	/**
	 * Собирает из коллекции составной массив ключ->значение
	 * @param  object|array $enumerable  массив массивов или объектов
	 * @param  string $key ключ
	 * @param  string $val значение
	 * @return array составной массив
	 */
	public static function arrayAssoc($enumerable, $key, $val)
	{
		$ret = array();
		foreach ($enumerable as $value)
		{
			if (is_array($value))
				$ret[$value[$key]] = $value[$val];
			else
				$ret[$value->$key] = $value->$val;
		}
		return $ret;
	}
}
