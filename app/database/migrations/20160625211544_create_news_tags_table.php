<?php

use Phinx\Migration\AbstractMigration;

class CreateNewsTagsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('news_tags', ['id' => false, 'primary_key' => ['news_id', 'tag_id']]);
		$table->addColumn('news_id', 'integer')
			->addColumn('tag_id', 'integer')
			->addIndex('tag_id')
			->addForeignKey('news_id', 'news', 'id',
				['delete'=> 'cascade', 'update' => 'restrict'])
			->addForeignKey('tag_id', 'tags', 'id',
				['delete'=> 'cascade', 'update' => 'restrict'])
			->create();
	}
}
