<?php

use Phinx\Migration\AbstractMigration;

class AddCategoryIdAndSlugToNews extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		News::connection()->query('TRUNCATE news');

		$table = $this->table('news');
		$table->addColumn('category_id', 'integer', ['after' => 'id'])
			->addColumn('slug', 'string', ['limit' => 50, 'after' => 'user_id'])
			->addForeignKey('category_id', 'categories', 'id',
				['delete'=> 'cascade', 'update' => 'restrict'])
			->addForeignKey('user_id', 'users', 'id',
				['delete'=> 'cascade', 'update' => 'restrict'])
			->update();
	}
}
