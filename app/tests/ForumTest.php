<?php

class ForumTest extends PHPUnit_Framework_TestCase
{
	public function testGetAll()
	{
		$forums = Forum::getAll();
		$this->assertTrue(is_array($forums));
	}
}
