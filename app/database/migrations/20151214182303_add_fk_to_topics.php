<?php

use Phinx\Migration\AbstractMigration;

class AddFkToTopics extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('topics');
		$table->addForeignKey('forum_id', 'forums', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->update();
	}
}
