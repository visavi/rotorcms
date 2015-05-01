<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#

/**
 * Gets the value of an environment variable. Supports boolean, empty and null.
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function env($key, $default = null)
{
	$value = getenv($key);
	if ($value === false) return value($default);
	switch (strtolower($value))
	{
		case 'true':
		case '(true)':
			return true;
		case 'false':
		case '(false)':
			return false;
		case 'empty':
		case '(empty)':
			return '';
		case 'null':
		case '(null)':
			return;
	}
	if (starts_with($value, '"') && str_finish($value, '"'))
	{
		return substr($value, 1, -1);
	}
	return $value;
}

/**
 * Обработка BB-кодов
 * @param  string  $text  Необработанный текст
 * @param  boolean $parse Обрабатывать или вырезать код
 * @return string         Обработанный текст
 */
function bb_code($text, $parse = true)
{
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
		$text = str_replace($code, '<img src="/assets/img/smiles/'.$smile.'" alt="'.$code.'"> ', $text);
	}

	return $text;
}

/**
 *  Количество пользователей
 * @return integer Количество пользователей
 */
function count_users()
{
	return User::count();
}

/**
 *  Количество сообщений в гостевой
 * @return integer сообщений в гостевой
 */
function count_guestbook()
{
	return Guestbook::count();
}

/**
 * Обработчик постраничной навигации
 * @param  integer $limit элементов на страницу
 * @param  integer $total всего элементов
 * @return array          массив подготовленных данных
 */
function getPage($limit, $total)
{
	$current = Request::input('page');
	if ($current < 1) $current = 1;

	if ($current * $limit >= $total) {
		$current = ceil($total / $limit);
	}

	$offset = intval(($current * $limit) - $limit);

	return compact('current', 'limit', 'offset', 'total');
}
