<?php

use Phinx\Migration\AbstractMigration;

class AddFkToGuestbook extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('guestbook');
		$table->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'set null', 'update' => 'restrict'])
		->update();
	}
}
