<?php

use Phinx\Migration\AbstractMigration;

class AddFkToPosts extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('posts');
		$table->addForeignKey('topic_id', 'topics', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->update();
	}
}
