<?php

use Phinx\Migration\AbstractMigration;

class AddFkToSpam extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('spam');
		$table
		->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->addForeignKey('relate_id', 'guest', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->addForeignKey('relate_id', 'posts', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->update();
	}
}
