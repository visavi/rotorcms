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
	if ($value === false) {
		return value($default);
	}
	switch (strtolower($value)) {
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
	if (strlen($value) > 1 && starts_with($value, '"') && str_finish($value, '"')) {
		return substr($value, 1, -1);
	}
	return $value;
}

/**
 *  Количество пользователей
 * @return integer Количество пользователей
 */
function usersCount()
{
	return User::count();
}

/**
 *  Количество сообщений в гостевой
 * @return integer сообщений в гостевой
 */
function guestbookCount()
{
	return Guestbook::count();
}

/**
 *  Количество сообщений в форума
 * @return integer сообщений в форуме
 */
function forumCount()
{
	return Topic::count().'/'.Post::count();
}

/**
 *  Количество новостей
 * @return integer количество новостей
 */
function newsCount()
{
	return News::count();
}
