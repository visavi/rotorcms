<?php

class Input {

	/**
	 * The decoded JSON content for the request.
	 *
	 * @var string
	 */
	protected $json;

	/**
	 * Return the Request instance.
	 *
	 * @return $this
	 */
	public function instance()
	{
		return $this;
	}

	/**
	 * Get the request method.
	 *
	 * @return string
	 */
	public function method()
	{
		return $this->getMethod();
	}

	/**
	 * Determine if the request contains a given input item key.
	 *
	 * @param  string|array  $key
	 * @return bool
	 */
	public function exists($key)
	{
		$keys = is_array($key) ? $key : func_get_args();

		$input = $this->all();

		foreach ($keys as $value)
		{
			if ( ! array_key_exists($value, $input)) return false;
		}

		return true;
	}

	/**
	 * Determine if the request contains a non-empty value for an input item.
	 *
	 * @param  string|array  $key
	 * @return bool
	 */
	public function has($key)
	{
		$keys = is_array($key) ? $key : func_get_args();

		foreach ($keys as $value)
		{
			if ($this->isEmptyString($value)) return false;
		}

		return true;
	}

	/**
	 * Determine if the given input key is an empty string for "has".
	 *
	 * @param  string  $key
	 * @return bool
	 */
	protected function isEmptyString($key)
	{
		$boolOrArray = is_bool($this->input($key)) || is_array($this->input($key));

		return ! $boolOrArray && trim((string) $this->input($key)) === '';
	}

	/**
	 * Get all of the input and files for the request.
	 *
	 * @return array
	 */
	public function all()
	{
		return array_replace_recursive($this->input(), $this->files->all());
	}

	/**
	 * Retrieve an input item from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	public function input($key = null, $default = null)
	{
		$input = $this->getInputSource()->all() + $this->query->all();

		return array_get($input, $key, $default);
	}

	/**
	 * Get a subset of the items from the input data.
	 *
	 * @param  array  $keys
	 * @return array
	 */
	public function only($keys)
	{
		$keys = is_array($keys) ? $keys : func_get_args();

		$results = [];

		$input = $this->all();

		foreach ($keys as $key)
		{
			array_set($results, $key, array_get($input, $key));
		}

		return $results;
	}

	/**
	 * Get all of the input except for a specified array of items.
	 *
	 * @param  array  $keys
	 * @return array
	 */
	public function except($keys)
	{
		$keys = is_array($keys) ? $keys : func_get_args();

		$results = $this->all();

		array_forget($results, $keys);

		return $results;
	}

	/**
	 * Retrieve a query string item from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	public function query($key = null, $default = null)
	{
		return $this->retrieveItem('query', $key, $default);
	}

	/**
	 * Determine if a cookie is set on the request.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function hasCookie($key)
	{
		return ! is_null($this->cookie($key));
	}

	/**
	 * Retrieve a cookie from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	public function cookie($key = null, $default = null)
	{
		return $this->retrieveItem('cookies', $key, $default);
	}

	/**
	 * Retrieve a file from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return \Symfony\Component\HttpFoundation\File\UploadedFile|array
	 */
	public function file($key = null, $default = null)
	{
		return array_get($this->files->all(), $key, $default);
	}

	/**
	 * Determine if the uploaded data contains a file.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function hasFile($key)
	{
		if ( ! is_array($files = $this->file($key))) $files = array($files);

		foreach ($files as $file)
		{
			if ($this->isValidFile($file)) return true;
		}

		return false;
	}

	/**
	 * Check that the given file is a valid file instance.
	 *
	 * @param  mixed  $file
	 * @return bool
	 */
	protected function isValidFile($file)
	{
		return $file instanceof SplFileInfo && $file->getPath() != '';
	}

	/**
	 * Retrieve a header from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	public function header($key = null, $default = null)
	{
		return $this->retrieveItem('headers', $key, $default);
	}

	/**
	 * Retrieve a server variable from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	public function server($key = null, $default = null)
	{
		return $this->retrieveItem('server', $key, $default);
	}

	/**
	 * Retrieve an old input item.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function old($key = null, $default = null)
	{
		return $this->session()->getOldInput($key, $default);
	}

	/**
	 * Flash the input for the current request to the session.
	 *
	 * @param  string  $filter
	 * @param  array   $keys
	 * @return void
	 */
	public function flash($filter = null, $keys = array())
	{
		$flash = ( ! is_null($filter)) ? $this->$filter($keys) : $this->input();

		$this->session()->flashInput($flash);
	}

	/**
	 * Flash only some of the input to the session.
	 *
	 * @param  mixed  string
	 * @return void
	 */
	public function flashOnly($keys)
	{
		$keys = is_array($keys) ? $keys : func_get_args();

		return $this->flash('only', $keys);
	}

	/**
	 * Flash only some of the input to the session.
	 *
	 * @param  mixed  string
	 * @return void
	 */
	public function flashExcept($keys)
	{
		$keys = is_array($keys) ? $keys : func_get_args();

		return $this->flash('except', $keys);
	}

	/**
	 * Flush all of the old input from the session.
	 *
	 * @return void
	 */
	public function flush()
	{
		$this->session()->flashInput(array());
	}

	/**
	 * Retrieve a parameter item from a given source.
	 *
	 * @param  string  $source
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	protected function retrieveItem($source, $key, $default)
	{
		if (is_null($key))
		{
			return $this->$source->all();
		}

		return $this->$source->get($key, $default, true);
	}

	/**
	 * Merge new input into the current request's input array.
	 *
	 * @param  array  $input
	 * @return void
	 */
	public function merge(array $input)
	{
		$this->getInputSource()->add($input);
	}
}
