<?php

use Phinx\Migration\AbstractMigration;

class CreateBookmarksTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('bookmarks');
		$table->addColumn('forum_id', 'integer', ['signed' => false])
			->addColumn('topic_id', 'integer', ['signed' => false])
			->addColumn('user_id', 'integer', ['signed' => false])
			->addColumn('posts', 'integer')
			->addColumn('created_at', 'timestamp')
			->addIndex('forum_id')
			->addIndex('topic_id')
			->addIndex('user_id')
			->create();
	}
}
