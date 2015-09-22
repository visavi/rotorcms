<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateTopicsTable extends AbstractMigration
{

	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('topics');
		$table->addColumn('forum_id', 'integer', ['signed' => false])
			->addColumn('user_id', 'integer', ['signed' => false])
			->addColumn('title', 'string', ['limit' => 50])
			->addColumn('closed', 'boolean', ['default' => false])
			->addColumn('locked', 'boolean', ['default' => false])
			->addColumn('mods', 'string', ['limit' => 100, 'null' => true])
			->addColumn('note', 'string', ['null' => true])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp')
			->addIndex('forum_id')
			->addIndex('locked')
			->addIndex('created_at')
			->create();

			// Удалить эту строку если версия MySQL ниже 5.6
			$mysql = $this->query("SHOW VARIABLES LIKE 'version'")->fetch();

			if(version_compare($mysql['Value'], '5.6.0', '>=')) {
				$this->execute('ALTER TABLE `topics` ADD FULLTEXT KEY (`title`)');
			}
	}
}
