<?php

use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('posts');
		$table->addColumn('forum_id', 'integer', ['signed' => false])
			->addColumn('topic_id', 'integer', ['signed' => false])
			->addColumn('user_id', 'integer', ['signed' => false])
			->addColumn('text', 'text')
			->addColumn('ip', 'string', ['limit' => 15])
			->addColumn('brow', 'string', ['limit' => 25])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp')
			->addIndex('forum_id')
			->addIndex(['topic_id', 'created_at'])
			->addIndex('user_id')
			->create();

			// Удалить эту строку если версия MySQL ниже 5.6
			$this->execute('ALTER TABLE `posts` ADD FULLTEXT KEY (`text`)');
	}
}
