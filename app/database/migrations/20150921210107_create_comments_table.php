<?php

use Phinx\Migration\AbstractMigration;

class CreateCommentsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('comments');
		$table->addColumn('user_id', 'integer')
			->addColumn('relate_type', 'enum', ['values' => ['news']])
			->addColumn('relate_id', 'integer')
			->addColumn('text', 'text')
			->addColumn('ip', 'string', ['limit' => 15])
			->addColumn('brow', 'string', ['limit' => 25])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp')
			->addIndex('user_id')
			->addIndex(['relate_type', 'relate_id'])
			->create();
	}
}