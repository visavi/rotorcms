<?php

use Phinx\Migration\AbstractMigration;

class CreateSettingsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('settings', ['id' => false, 'primary_key' => 'name']);
		$table->addColumn('name', 'string')
			->addColumn('value', 'string')
			->create();
	}
}
