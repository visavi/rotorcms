<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateForumsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('forums');
		$table->addColumn('sort', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'default' => 0])
			->addColumn('parent_id', 'integer', ['default' => 0])
			->addColumn('title', 'string', ['limit' => 50])
			->addColumn('description', 'string', ['null' => true])
			->addColumn('closed', 'boolean', ['default' => false])
			->addColumn('topic_last_id', 'integer', ['null' => true])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp', ['null' => true])
			->create();
	}
}
