<?php

use Phinx\Migration\AbstractMigration;

class AddFkToBookmarks extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('bookmarks');
		$table->addForeignKey('topic_id', 'topics', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->update();
	}
}
