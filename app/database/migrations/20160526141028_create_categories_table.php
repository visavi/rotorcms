<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateCategoriesTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('categories');
		$table->addColumn('sort', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'default' => 0])
			->addColumn('parent_id', 'integer', ['default' => 0])
			->addColumn('name', 'string', ['limit' => 50])
			->addColumn('slug', 'string', ['limit' => 50])
			->addColumn('description', 'text', ['null' => true])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp', ['null' => true])
			->create();
	}
}
