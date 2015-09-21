<?php

use Phinx\Migration\AbstractMigration;

class CreateSocialsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('socials');
		$table->addColumn('user_id', 'integer', ['signed' => false])
			->addColumn('network', 'string')
			->addColumn('uid', 'string')
			->addIndex('user_id')
			->create();
	}
}
