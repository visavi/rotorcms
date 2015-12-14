<?php

use Phinx\Migration\AbstractMigration;

class AddFkToSocials extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('socials');
		$table->addForeignKey('user_id', 'users', 'id',
			['delete'=> 'cascade', 'update' => 'restrict'])
		->update();
	}
}
