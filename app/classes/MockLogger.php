<?php

class MockLogger
{
	public $logs = array();

	public function log($message)
	{
		$this->logs[] = $message;
	}

	public function clear()
	{
		$this->logs = array();
	}

	public function getLogs()
	{
		var_dump($this->logs);
	}
}
