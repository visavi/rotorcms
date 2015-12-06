<?php

use Phinx\Seed\AbstractSeed;

class ForumsSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		// Заполнение разделов
		$data = [
			[
				'sort' => 0,
				'parent_id' => 0,
				'title' => 'Первый раздел',
				'description' => 'Описание раздела',
				'closed' => 0,
				'created_at' => Carbon::now(),
			],
			[
				'sort'  => 1,
				'parent_id' => 0,
				'title' => 'Второй раздел',
				'description' => 'Описание раздела',
				'closed' => 0,
				'created_at' => Carbon::now(),
			],
			[
				'sort' => 2,
				'parent_id' => 0,
				'title' => 'Третий раздел (закрыт)',
				'description' => 'Описание раздела',
				'closed' => 1,
				'created_at' => Carbon::now(),
			],
			[
				'sort' => 0,
				'parent_id' => 1,
				'title' => 'Первый подраздел',
				'description' => 'Описание раздела',
				'closed' => 0,
				'created_at' => Carbon::now(),
			],
			[
				'sort' => 1,
				'parent_id' => 1,
				'title' => 'Второй подраздел (закрыт)',
				'description' => 'Описание раздела',
				'closed' => 1,
				'created_at' => Carbon::now(),
			],
		];

		$table = $this->table('forums');
		$table->insert($data)->save();

		// Заполнение тем
		$data = [
			[
				'forum_id' => 1,
				'user_id' => 1,
				'title' => 'Первая тема',
				'note' => 'Объявление',
				'closed' => 0,
				'created_at' => Carbon::now(),
			],
			[
				'forum_id' => 1,
				'user_id' => 2,
				'title' => 'Вторая тема (Закрыта)',
				'note' => 'Объявление',
				'closed' => 1,
				'created_at' => Carbon::now(),
			],
			[
				'forum_id' => 1,
				'user_id' => 3,
				'title' => 'Третья тема (Закреплена)',
				'note' => 'Объявление',
				'locked' => 1,
				'created_at' => Carbon::now(),
			],
			[
				'forum_id' => 2,
				'user_id' => 1,
				'title' => 'Тема в другом разделе',
				'note' => 'Объявление',
				'closed' => 0,
				'created_at' => Carbon::now(),
			],
		];

		$table = $this->table('topics');
		$table->insert($data)->save();
	}
}
