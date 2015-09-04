<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateStatusTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$status = $this->table('status2');
		$status->addColumn('point', 'integer', ['signed' => false])
			->addColumn('topoint', 'integer', ['signed' => false])
			->addColumn('name', 'string', array('limit' => 50))
			->addColumn('color', 'string', array('limit' => 10))
			->create();
	}
}
