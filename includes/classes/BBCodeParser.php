<?php

class BBCodeParser {

	public $parsers = array(
		'code' => array(
			'pattern' => '/\[code\](.*?)\[\/code\]/s',
			'callback' => 'highlight_code'
		),
		'bold' => array(
			'pattern' => '/\[b\](.*?)\[\/b\]/s',
			'replace' => '<strong>$1</strong>',
		),
		'italic' => array(
			'pattern' => '/\[i\](.*?)\[\/i\]/s',
			'replace' => '<em>$1</em>',
		),
		'underLine' => array(
			'pattern' => '/\[u\](.*?)\[\/u\]/s',
			'replace' => '<u>$1</u>',
		),
		'lineThrough' => array(
			'pattern' => '/\[s\](.*?)\[\/s\]/s',
			'replace' => '<strike>$1</strike>',
		),
		'fontSize' => array(
			'pattern' => '/\[size\=([1-5])\](.*?)\[\/size\]/s',
			'replace' => '<font size="$1">$2</font>',
		),
		'fontColor' => array(
			'pattern' => '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/color\]/s',
			'replace' => '<font color="$1">$2</font>',
			'iterate' => 1,
		),
		'center' => array(
			'pattern' => '/\[center\](.*?)\[\/center\]/s',
			'replace' => '<div style="text-align:center;">$1</div>',
		),
		'quote' => array(
			'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
			'replace' => '<blockquote>$1</blockquote>',
			'iterate' => 3,
		),
		'namedQuote' => array(
			'pattern' => '/\[quote\=(.*?)\](.*)\[\/quote\]/s',
			'replace' => '<blockquote>$2<small>$1</small></blockquote>',
			'iterate' => 3,
		),
		'link' => array(
			'pattern' => '/\[url\](.*?)\[\/url\]/s',
			'replace' => '<a href="$1">$1</a>',
		),
		'namedLink' => array(
			'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
			'replace' => '<a href="$1">$2</a>',
		),
		//'image' => array(
		//	'pattern' => '/\[img\](.*?)\[\/img\]/ms',
		//	'replace' => '<img src="$1">',
		//),
/*		'orderedList' => array(
			'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
			'replace' => '<ol>$1</ol>',
		),
		'unorderedList' => array(
			'pattern' => '/\[list\](.*?)\[\/list\]/s',
			'replace' => '<ul>$1</ul>',
		),
		'listItem' => array(
			'pattern' => '/\[\*\](.*)/',
			'replace' => '<li>$1</li>',
		),*/
		'spoiler' => array(
			'pattern' => '/\[spoiler\](.*?)\[\/spoiler\]/s',
			'callback' => 'spoiler_text',
			'iterate' => 1,
		),
		'shortSpoiler' => array(
			'pattern' => '/\[spoiler\=(.*?)\](.*?)\[\/spoiler\]/s',
			'callback' => 'spoiler_text',
			'iterate' => 1,
		),
		'hide' => array(
			'pattern' => '/\[hide\](.*?)\[\/hide\]/s',
			'callback' => 'hidden_text',
		),
		'youtube' => array(
			'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
			'replace' => '<iframe width="320" height="240" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
		),
	);

	/**
	 * Метод парсинга BBCode
	 * @param  string $source текст содержаший BBCode
	 * @return string распарсенный текст
	 */
	public function parse($source) {
		$source = nl2br($source);

		foreach ($this->parsers as $parser) {

			$iterate = isset($parser['iterate']) ? $parser['iterate'] : 0;

			for ($i = 0; $i <= $iterate; $i++) {
				if (isset($parser['callback'])) {
					$source = preg_replace_callback($parser['pattern'], array($this, $parser['callback']), $source);
				} else {
					$source = preg_replace($parser['pattern'], $parser['replace'], $source);
				}
			}
		}
		return $source;
	}

	/**
	 * Подсветка кода
	 * @param callable $match массив элементов
	 * @return string текст с подсветкой
	 */
	public function highlight_code($match) {

		//Чтобы bb-код и смайлы не работали внутри тега [code]
		$match[1] = strtr($match[1], array(':' => '&#58;', '[' => '&#91;'));

		return '<pre class="prettyprint linenums">'.$match[1].'</pre>';
	}

	/**
	 * Скрытие текста под спойлер
	 * @param callable $match массив элементов
	 * @return string код спойлера
	 */
	public function spoiler_text($match) {

		$title = (empty($match[1]) || !isset($match[2])) ? 'Развернуть для просмотра' : $match[1];
		$text = (empty($match[2])) ? !isset($match[2]) ? $match[1] : 'Текст отсуствует' : $match[2];

		return '<div class="spoiler">
				<b class="spoiler-title">'.$title.'</b>
				<div class="spoiler-text" style="display: none;">'.$text.'</div>
			</div>';
	}

	/**
	 * Скрытие текста от неавторизованных пользователей
	 * @param callable $match массив элементов
	 * @return string  скрытый код
	 */
	public function hidden_text($match) {

		if (empty($match[1])) $match[1] = 'Текст отсутствует';

		return '<div class="hiding">
				<span class="strong">Скрытый контент:</span> '.(is_user() ? $match[1] : 'Для просмотра необходимо авторизоваться!').
				'</div>';
	}

	/**
	 * Sets the parser pattern and replace.
	 * This can be used for new parsers or overwriting existing ones.
	 * @param string $name Parser name
	 * @param string $pattern Pattern
	 * @param string $replace Replace pattern
	 */
	public function setParser($name, $pattern, $replace) {

		$this->parsers[$name] = array(
			'pattern' => $pattern,
			'replace' => $replace
		);
	}

	/**
	 * Limits the parsers to only those you specify
	 * @param  mixed $only parsers
	 * @return object BBCodeParser object
	 */
	public function only($only = null) {

		$only = (is_array($only)) ? $only : func_get_args();
		$this->parsers = $this->arrayOnly($only);
		return $this;
	}

	/**
	 * Removes the parsers you want to exclude
	 * @param  mixed $except parsers
	 * @return object BBCodeParser object
	 */
	public function except($except = null) {

		$except = (is_array($except)) ? $except : func_get_args();
		$this->parsers = $this->arrayExcept($except);
		return $this;
	}

	/**
	 * List of all available parsers
	 * @return array array of available parsers
	 */
	public function getAvailableParsers() {

		return $this->availableParsers;
	}

	/**
	 * List of chosen parsers
	 * @return array array of parsers
	 */
	public function getParsers() {

		return $this->parsers;
	}

	/**
	 * Filters all parsers that you don´t want
	 * @param  array $only chosen parsers
	 * @return array parsers
	 */
	private function arrayOnly($only) {

		return array_intersect_key($this->parsers, array_flip((array) $only));
	}

	/**
	 * Removes the parsers that you don´t want
	 * @param  array $except parsers to exclude
	 * @return array parsers
	 */
	private function arrayExcept($excepts) {

		return array_diff_key($this->parsers, array_flip((array) $excepts));
	}

}
