<?php

class BBCodeParser {

    public $availableParsers = array(
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
            'pattern' => '/\[size\=([1-7])\](.*?)\[\/size\]/s',
            'replace' => '<font size="$1">$2</font>',
        ),
        'fontColor' => array(
            'pattern' => '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/color\]/s',
            'replace' => '<font color="$1">$2</font>',
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
            'replace' => '<blockquote><small>$1</small>$2</blockquote>',
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
        'image' => array(
            'pattern' => '/\[img\](.*?)\[\/img\]/s',
            'replace' => '<img src="$1">',
        ),
        'orderedListNumerical' => array(
            'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
            'replace' => '<ol>$1</ol>',
        ),
        'orderedListAlpha' => array(
            'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
            'replace' => '<ol type="a">$1</ol>',
        ),
        'orderedListDeprecated' => array(
            'pattern' => '/\[ol\](.*?)\[\/ol\]/s',
            'replace' => '<ol>$1</ol>',
        ),
        'unorderedList' => array(
            'pattern' => '/\[list\](.*?)\[\/list\]/s',
            'replace' => '<ul>$1</ul>',
        ),
        'unorderedListDeprecated' => array(
            'pattern' => '/\[ul\](.*?)\[\/ul\]/s',
            'replace' => '<ul>$1</ul>',
        ),
        'listItem' => array(
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>',
        ),
        'code' => array(
            'pattern' => '/\[code\](.*?)\[\/code\]/s',
            'replace' => '<code>$1</code>',
        ),
        'youtube' => array(
            'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
            'replace' => '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
        ),
        'linebreak' => array(
            'pattern' => '/\r/',
            'replace' => '<br />',
        )
    );


    private $parsers;

    public function __construct(array $parsers = null)
    {
        $this->parsers = ($parsers === null) ? $this->availableParsers : $parsers;
    }

    /**
     * Parses the BBCode string
     * @param  string $source String containing the BBCode
     * @return string Parsed string
     */
    public function parse($source)
    {
        foreach ($this->parsers as $name => $parser) {
            if(isset($parser['iterate']))
            {
                for ($i=0; $i <= $parser['iterate']; $i++) {
                    $source = preg_replace($parser['pattern'], $parser['replace'], $source);
                }
            }
            else {
                $source = preg_replace($parser['pattern'], $parser['replace'], $source);
            }
        }
        return $source;
    }

    /**
     * Sets the parser pattern and replace.
     * This can be used for new parsers or overwriting existing ones.
     * @param string $name Parser name
     * @param string $pattern Pattern
     * @param string $replace Replace pattern
     */
    public function setParser($name, $pattern, $replace)
    {
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
    public function only($only = null)
    {
        $only = (is_array($only)) ? $only : func_get_args();
        $this->parsers = $this->arrayOnly($only);
        return $this;
    }

    /**
     * Removes the parsers you want to exclude
     * @param  mixed $except parsers
     * @return object BBCodeParser object
     */
    public function except($except = null)
    {
        $except = (is_array($except)) ? $except : func_get_args();
        $this->parsers = $this->arrayExcept($except);
        return $this;
    }

    /**
     * List of all available parsers
     * @return array array of available parsers
     */
    public function getAvailableParsers()
    {
        return $this->availableParsers;
    }

    /**
     * List of chosen parsers
     * @return array array of parsers
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * Filters all parsers that you don´t want
     * @param  array $only chosen parsers
     * @return array parsers
     */
    private function arrayOnly($only)
    {
        return array_intersect_key($this->parsers, array_flip((array) $only));
    }

    /**
     * Removes the parsers that you don´t want
     * @param  array $except parsers to exclude
     * @return array parsers
     */
    private function arrayExcept($excepts)
    {
        return array_diff_key($this->parsers, array_flip((array) $excepts));
    }

}
