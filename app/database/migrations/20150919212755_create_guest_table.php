<?php

use Phinx\Migration\AbstractMigration;

class CreateGuestTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$status = $this->table('guest');
		$status->addColumn('user_id', 'integer', ['signed' => false, 'null' => true])
			->addColumn('text', 'text')
			->addColumn('ip', 'string', ['limit' => 15])
			->addColumn('brow', 'string', array('limit' => 25))
			->addColumn('reply', 'text')
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp')
			->addIndex('created_at')
			->create();
	}
}
