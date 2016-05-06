<?php

use Phinx\Migration\AbstractMigration;

class CreateStatusTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('status');
		$table->addColumn('point', 'integer', ['signed' => false])
			->addColumn('topoint', 'integer', ['signed' => false])
			->addColumn('name', 'string', ['limit' => 50])
			->addColumn('color', 'string', ['limit' => 10, 'null' => true])
			->create();
	}
}
