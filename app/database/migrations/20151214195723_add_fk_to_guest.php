<?php

use Phinx\Migration\AbstractMigration;

class AddFkToGuest extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('guest');
		$table->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'set null', 'update' => 'restrict'])
		->update();
	}
}
