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
	public static function returnUrl($url = null)
	{
		//if (Request::path() == '/') return $page;

		$query = Request::has('return') ? Request::input('return') : Request::path();
		return 'return='.urlencode(is_null($url) ? $query : $url);
	}

	/**
	 * Метод подключения шаблонов
	 * @param  string  $view   имя шаблона
	 * @param  array   $params массив параметров
	 * @param  boolean $return выводить или возвращать код
	 * @return string          сформированный код
	 */
	public static function view($template, $params = [], $return = false)
	{
		$blade = new Blade(APP.'/views', STORAGE.'/cache');

		if ($return) {
			return $blade->view()->make($template, $params)->render();
		} else {
			echo $blade->view()->make($template, $params)->render();
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

		App::view('errors.'.$code, compact('message'));
	}

	/**
	 * Постраничная навигация
	 * @param  array $page массив данных
	 * @return string  сформированный блок с кнопками страниц
	 */
	public static function pagination($page)
	{
		if ($page['total'] > 0) {

			if (empty($page['crumbs'])) $page['crumbs'] = 3;

			$url = array_except($_GET, 'page');
			$request = $url ? '&'.http_build_query($url) : null;

			$pages = [];
			$pg_cnt = ceil($page['total'] / $page['limit']);
			$idx_fst = max($page['current'] - $page['crumbs'], 1);
			$idx_lst = min($page['current'] + $page['crumbs'], $pg_cnt);

			if ($page['current'] != 1) {
				$pages[] = [
					'page' => $page['current'] - 1,
					'title' => 'Предыдущая',
					'name' => '«',
				];
			}

			if ($page['current'] > $page['crumbs'] + 1) {
				$pages[] = [
					'page' => 1,
					'title' => '1 страница',
					'name' => 1,
				];
				if ($page['current'] != $page['crumbs'] + 2) {
					$pages[] = [
						'separator' => true,
						'name' => ' ... ',
					];
				}
			}

			for ($i = $idx_fst; $i <= $idx_lst; $i++) {
				if ($i == $page['current']) {
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

			if ($page['current'] < $pg_cnt - $page['crumbs']) {
				if ($page['current'] != $pg_cnt - $page['crumbs'] - 1) {
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

			if ($page['current'] != $pg_cnt) {
				$pages[] = [
					'page' => $page['current'] + 1,
					'title' => 'Следующая',
					'name' => '»',
				];
			}

			self::view('app._pagination', compact('pages', 'request'));
		}
	}

	// ----------------------- Вывод страниц в форуме ------------------------//
	public static function forumPagination($topic) {

		if ($topic->postCount()) {

			$pages = [];
			$link = '/topic/'.$topic->id;

			$pg_cnt = ceil($topic->postCount() / Setting::get('posts_per_page'));

			for ($i = 1; $i <= 5; $i++) {
				if ($i <= $pg_cnt) {
					$pages[] = [
						'page' => $i,
						'title' => $i.' страница',
						'name' => $i,
					];
				}
			}

			if (5 < $pg_cnt) {

				if (6 < $pg_cnt) {
					$pages[] = array(
						'separator' => true,
						'name' => ' ... ',
					);
				}

				$pages[] = array(
					'page' => $pg_cnt,
					'title' => $pg_cnt.' страница',
					'name' => $pg_cnt,
				);
			}

			self::view('forums._pagination', compact('pages', 'link'));
		}
	}

	/**
	 * Обработчик постраничной навигации
	 * @param  integer $limit элементов на страницу
	 * @param  integer $total всего элементов
	 * @return array          массив подготовленных данных
	 */
	public static function paginate($limit, $total)
	{
		$current = Request::input('page');
		if ($current < 1) $current = 1;

		if ($total && $current * $limit >= $total) {
			$current = ceil($total / $limit);
		}

		$offset = intval(($current * $limit) - $limit);

		return compact('current', 'offset', 'limit', 'total');
	}

	/**
	 * Навигация
	 * @param  array   $crumbs массив ссылок
	 * @param  boolean $return возвращать или выводить
	 * @return string          сформированный код
	 */
	public static function breadcrumbs($crumbs)
	{
		return self::view('app._breadcrumbs', compact('crumbs'), true);
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
		if (empty($headers['from'])) $headers['from'] = [env('SITE_EMAIL') => env('SITE_ADMIN')];

		$message = Swift_Message::newInstance()
			->setTo($to)
			->setSubject($subject)
			->setBody($body, 'text/html')
			->setFrom($headers['from'])
			->setReturnPath(env('SITE_EMAIL'));

		if (env('MAIL_DRIVER') == 'smtp') {
			$transport = Swift_SmtpTransport::newInstance(env('MAIL_HOST'), env('MAIL_PORT'), 'ssl')
				->setUsername(env('MAIL_USERNAME'))
				->setPassword(env('MAIL_PASSWORD'));
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
		$size = array('B','kB','MB','GB','TB');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	/**
	 * Склонение чисел
	 * @param  integer $num  число
	 * @param  array   $forms массив склоняемых слов (один, два, много)
	 * @return string  форматированная строка
	 */
	public static function plural($num, array $forms)
	{
		if ($num % 100 > 10 &&  $num % 100 < 15) return $num.' '.$forms[2];
		if ($num % 10 == 1) return $num.' '.$forms[0];
		if ($num % 10 > 1 && $num %10 < 5) return $num.' '.$forms[1];
		return $num.' '.$forms[2];
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
	 * Обработка BB-кодов
	 * @param  string  $text  Необработанный текст
	 * @param  boolean $parse Обрабатывать или вырезать код
	 * @return string         Обработанный текст
	 */
	public static function bbCode($text, $parse = true)
	{
		$bbcode = new BBCodeParser;

		if ( ! $parse) return $bbcode->clear($text);

		$text = $bbcode->parse($text);
		$text = $bbcode->parseSmiles($text);

		return $text;
	}

	/**
	 * Определение браузера
	 * @return string браузер и версия браузера
	 */
	public static function getUserAgent($userAgent = null)
	{
		$browser = new Browser();
		if ($userAgent) $browser->setUserAgent($userAgent);

		$brow = $browser->getBrowser();
		$version = implode('.', array_slice(explode('.', $browser->getVersion()), 0, 2));
		return $version == 'unknown' ? $brow : $brow.' '.$version;
	}

	/**
	 * Определение IP пользователя
	 * @return string IP пользователя
	 */
	public static function getClientIp()
	{
		$ip = Request::ip();
		return $ip == '::1' ? '127.0.0.1' : $ip;
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
