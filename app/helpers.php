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
 *  Количество сообщений в форума
 * @return integer сообщений в форуме
 */
function count_forum()
{
	return Topic::count().'/'.Post::count();
}
