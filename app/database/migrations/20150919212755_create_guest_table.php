<?php

use Phinx\Migration\AbstractMigration;

class CreateGuestTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('guest');
		$table->addColumn('user_id', 'integer', ['signed' => false, 'null' => true])
			->addColumn('text', 'text')
			->addColumn('ip', 'string', ['limit' => 15])
			->addColumn('brow', 'string', ['limit' => 25])
			->addColumn('reply', 'text')
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp')
			->addIndex('created_at')
			->create();
	}
}
