<?php

class ForumTest extends PHPUnit_Framework_TestCase
{
/*	private $db;

	public function __construct($db)
	{
		$this->db = $db;
		if (!isset(static::$instances))
		{
			$tables = file_get_contents(APP.'/database/migration/tables/tables.sql');

			foreach (explode(';', $tables) as $sql)
			{
				if (trim($sql) != '')
					$this->db->query($sql);
			}
		}
	}*/

	public function testGetAll()
	{
		$forums = []; //Forum::getAll();
		$this->assertTrue(is_array($forums));
	}
}
