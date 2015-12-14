<?php

use Phinx\Migration\AbstractMigration;

class AddFkToComments extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('comments');
		$table
		->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->addForeignKey('relate_id', 'news', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->update();
	}
}
