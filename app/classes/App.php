<?php
class App
{
	/**
	 * Метод подключения шаблонов
	 * @param  string  $view   имя шаблона
	 * @param  array   $params массив параметров
	 * @return string сформированный код
	 */
	public static function view($view, $params = []){
		global $config, $router, $request_uri;

		$blade = new Philo\Blade\Blade(BASEDIR.'/app/views', DATADIR.'/cache');

		$params += compact('router', 'config', 'request_uri');
		echo $blade->view()->make($view, $params);
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
	public static function pagination($url, $rpp, $current, $total, $crumbs = 3) {

		if ($total > 0) {
			$request = null;
			if (($strpos = strpos($url, '?')) !== false) {
				$request = substr($url, $strpos);
				$url = substr($url, 0, $strpos);
			}

			$pages = array();
			$pg_cnt = ceil($total / $rpp);
			$idx_fst = max($current - $crumbs, 1);
			$idx_lst = min($current + $crumbs, $pg_cnt);

			if ($current != 1) {
				$pages[] = array(
					'start' => $current - 1,
					'title' => 'Предыдущая',
					'name' => '«',
				);
			}
			if (($current - $idx_fst) >= 0) {
				if ($current > ($crumbs + 1)) {
					$pages[] = array(
						'start' => 1,
						'title' => '1 страница',
						'name' => 1,
					);
					if ($current != ($crumbs + 2)) {
						$pages[] = array(
							'separator' => true,
							'name' => ' ... ',
						);
					}
				}
			}

			for ($i = $idx_fst; $i <= $idx_lst; $i++) {

				if ($i == $current) {
					$pages[] = array(
						'current' => true,
						'name' => $i,
					);
				} else {
					$pages[] = array(
						'start' => $i,
						'title' => $i.' страница',
						'name' => $i,
					);
				}
			}
			if (($current + $idx_lst) < $total) {
				if ($current < ($pg_cnt - $crumbs)) {
					if ($current != ($pg_cnt - $crumbs - 1)) {
						$pages[] = array(
							'separator' => true,
							'name' => ' ... ',
						);
					}
					$pages[] = array(
						'start' => $pg_cnt,
						'title' => $pg_cnt . ' страница',
						'name' => $pg_cnt,
					);
				}
			}
			if ($current != $pg_cnt) {
				$pages[] = array(
					'start' => $current + 1,
					'title' => 'Следующая',
					'name' => '»',
				);
			}

			self::render('includes/pagination', compact('pages', 'url', 'request'));
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
