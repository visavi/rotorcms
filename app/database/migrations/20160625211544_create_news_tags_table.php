<?php

use Phinx\Migration\AbstractMigration;

class CreateNewsTagsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('news_tags', ['id' => false, 'primary_key' => ['news_id', 'tags_id']]);
		$table->addColumn('news_id', 'integer')
			->addColumn('tags_id', 'integer')
			->addIndex('tags_id')
			->addForeignKey('news_id', 'news', 'id',
				['delete'=> 'cascade', 'update' => 'restrict'])
			->addForeignKey('tags_id', 'tags', 'id',
				['delete'=> 'cascade', 'update' => 'restrict'])
			->create();
	}
}
