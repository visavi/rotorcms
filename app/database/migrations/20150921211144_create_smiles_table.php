<?php

use Phinx\Migration\AbstractMigration;

class CreateSmilesTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('smiles');
		$table->addColumn('name', 'string', ['limit' => 25])
			->addColumn('code', 'string', ['limit' => 20])
			->addIndex('code')
			->create();
	}
}
