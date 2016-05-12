<?php

use Phinx\Migration\AbstractMigration;

class CreateSpamTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('spam');
		$table->addColumn('user_id', 'integer')
			->addColumn('relate_type', 'enum', ['values' => ['Guestbook', 'Post']])
			->addColumn('relate_id', 'integer')
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp', ['null' => true])
			->addIndex(['relate_type', 'relate_id'])
			->addIndex('created_at')
			->create();
	}
}
