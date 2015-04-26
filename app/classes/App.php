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
	 * @param  boolean $path показывать только путь
	 * @return string текущая страница
	 */
/*	public static function requestUrl($path = false)
	{
		$current = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

		if ($path && ($strpos = strpos($current, '?')) !== false) {
			$current = substr($current, 0, $strpos);
		}

		return $current;
	}*/

/*	/**
	 * Получает текущий метод запроса
	 * @return string текущий метод запроса

	public static function requestMethod()
	{
		return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
	}*/

	/**
	 * Получает текущую страницу
	 * @return string текущая страница
	 */
	public static function returnUrl($page, $url = null)
	{
		if (Request::path() == '/') return $page;

		$query = Request::has('return') ? Request::input('return') : Request::path();
		return $page.'?return='.urlencode(is_null($url) ? $query : $url);
	}

	/**
	 * Метод подключения шаблонов
	 * @param  string  $view   имя шаблона
	 * @param  array   $params массив параметров
	 * @param  boolean $return выводить или возвращать код
	 * @return string          сформированный код
	 */
	public static function view($view, $params = [], $return = false)
	{
		$blade = new Blade(APP.'/views', STORAGE.'/cache');

		if ($return) {
			return $blade->view()->make($view, $params)->render();
		} else {
			echo $blade->view()->make($view, $params)->render();
		}
	}

	/**
	 * Метод вывода страницы с ошибками
	 * @param  integer $code    код ошибки
	 * @param  string  $message текст ошибки
	 * @return string  сформированная страница с ошибкой
	 */
	public static function abort($code, $message = '')
	{
		if ($code == 403) {
			header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden');
		}

		if ($code == 404) {
			header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
		}

		exit(App::view('errors.'.$code, compact('message')));
	}

	/**
	 * Постраничная навигация
	 * @param  integer $rpp     количество элементов на странице
	 * @param  integer $current текущая страница
	 * @param  integer $total   общее количество элементов
	 * @param  integer $crumbs  количество кнопок справа и слева
	 * @return string  сформированный блок с кнопками страниц
	 */
	public static function pagination($rpp, $current, $total, $crumbs = 3)
	{
		if ($total > 0) {

			$url = array_except($_GET, 'page');
			$request = $url ? '&'.http_build_query($url) : null;

			$pages = [];
			$pg_cnt = ceil($total / $rpp);
			$idx_fst = max($current - $crumbs, 1);
			$idx_lst = min($current + $crumbs, $pg_cnt);

			if ($current != 1) {
				$pages[] = [
					'page' => $current - 1,
					'title' => 'Предыдущая',
					'name' => '«',
				];
			}
			if (($current - $idx_fst) >= 0) {
				if ($current > ($crumbs + 1)) {
					$pages[] = [
						'page' => 1,
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
						'page' => $i,
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
						'page' => $pg_cnt,
						'title' => $pg_cnt . ' страница',
						'name' => $pg_cnt,
					];
				}
			}
			if ($current != $pg_cnt) {
				$pages[] = [
					'page' => $current + 1,
					'title' => 'Следующая',
					'name' => '»',
				];
			}

			self::view('app._pagination', compact('pages', 'request'));
		}
	}

	/**
	 * Навигация
	 * @param  array   $crumbs массив ссылок
	 * @param  boolean $return возвращать или выводить
	 * @return string          сформированный код
	 */
	public static function breadcrumbs($crumbs, $return = false)
	{
		return self::view('app._breadcrumbs', compact('crumbs'), $return);
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
		if (isset($_SESSION['captcha'])) $_SESSION['captcha'] = null;

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
		self::view('app._flash');
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
	public static function isMail($email)
	{
		return preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#', $email);
	}

	/**
	 * Отправка уведомления на email
	 * @param  mixed   $to      Получатель
	 * @param  string  $subject Тема письма
	 * @param  string  $body    Текст сообщения
	 * @param  array   $headers Дополнительные параметры
	 * @return boolean  Результат отправки
	 */
	public static function sendMail($to, $subject, $body, $headers = [])
	{
		if (empty($headers['from'])) $headers['from'] = [Setting::get('email') => Setting::get('admin')];

		$message = Swift_Message::newInstance()
			->setTo($to)
			->setSubject($subject)
			->setBody($body, 'text/html')
			->setFrom($headers['from'])
			->setReturnPath(Setting::get('email'));

		if (Setting::get('mail_protocol') == 'smtp') {
			$smtp = explode(',', Setting::get('mail_smtp'));
			$transport = Swift_SmtpTransport::newInstance($smtp[0], $smtp[1], $smtp[2])
				->setUsername(Setting::get('mail_username'))
				->setPassword(Setting::get('mail_password'));
		} else {
			$transport = new Swift_MailTransport();
		}

		$mailer = new Swift_Mailer($transport);
		return $mailer->send($message);
	}

	/**
	 * Форматирование даты
	 * @param string $format отформатированная дата
	 * @param mixed  $date временная метки или дата
	 * @return string отформатированная дата
	 */
	public static function date($format, $date = null)
	{
		$date = (is_null($date)) ? time() : strtotime($date);

		$eng = array('January','February','March','April','May','June','July','August','September','October','November','December');
		$rus = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
		return str_replace($eng, $rus, date($format, $date));
	}

	/**
	 * Получение расширения файла
	 * @param  string $filename имя файла
	 * @return string расширение
	 */
	public static function getExtension($filename)
	{
		return pathinfo($filename, PATHINFO_EXTENSION);
	}

	/**
	 * Красивый вывод размера файла
	 * @param  string  $filename путь к файлу
	 * @param  integer $decimals кол. чисел после запятой
	 * @return string            форматированный вывод размера
	 */
	public static function filesize($filename, $decimals = 1)
	{
		if (!file_exists($filename)) return 0;

		$bytes = filesize($filename);
		$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	/**
	 * Склонение чисел
	 * @param  integer $num  число
	 * @param  array   $forms массив склоняемых слов
	 * @return string  форматированная строка
	 */
	public static function plural($num, $forms)
	{
		if ($num % 100 > 10 &&  $num % 100 < 15) return $num.' '.$forms[2];
		if ($num % 10 == 1) return $num.' '.$forms[0];
		if ($num % 10 > 1 && $num %10 < 5) return $num.' '.$forms[1];
		return $num.' '.$forms[2];
	}

public static function bbCode($text, $parse = true) {

	static $list_smiles;

	$bbcode = new BBCodeParser;

	if ( ! $parse) return $bbcode->clear($text);

	$text = $bbcode->parse($text);

	if (empty($list_smiles)) {

		if (!file_exists(STORAGE.'/temp/smiles.dat')) {

			$smiles = Smile::all(array('order' => 'LENGTH(code) desc'));
			$smiles = self::arrayAssoc($smiles, 'code', 'name');
			file_put_contents(STORAGE.'/temp/smiles.dat', serialize($smiles));
		}

		$list_smiles = unserialize(file_get_contents(STORAGE."/temp/smiles.dat"));
	}

	foreach($list_smiles as $code => $smile) {
		$text = str_replace($code, '<img src="/assets/img/smiles/'.$smile.'" alt="'.$code.'" /> ', $text);
	}

	return $text;
}

	/**
	 * Метод валидации дат
	 * @param  string $date   дата
	 * @param  string $format формат даты
	 * @return boolean        результат валидации
	 */
	public static function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	/**
	 * Метод обработки массивов
	 * @param  array $array необработанный массив
	 * @return array обработанный массив
	 */
	public static function arrayPrepare($array)
	{
		$array_prepare = array();
		if ( is_array($array) )
		{
			foreach($array as $property => $keys) {
				if (is_array($keys)) {
					foreach($keys as $key => $value) {
						$array_prepare[$key][$property] = $value;
					}
				} else {
					$array_prepare[$property] = $keys;
				}
			}
		}
		return $array_prepare;
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
