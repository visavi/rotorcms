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
		->update();
	}
}
