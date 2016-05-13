<?php

use Phinx\Migration\AbstractMigration;

class CreateGuestbookTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('guestbook');
		$table->addColumn('user_id', 'integer', ['null' => true])
			->addColumn('text', 'text', ['null' => true])
			->addColumn('ip', 'string', ['limit' => 15])
			->addColumn('brow', 'string', ['limit' => 25])
			->addColumn('reply', 'text', ['null' => true])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp', ['null' => true])
			->addIndex('created_at')
			->create();
	}
}
