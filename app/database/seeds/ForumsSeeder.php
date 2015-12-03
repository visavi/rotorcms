<?php

use Phinx\Seed\AbstractSeed;

class ForumsSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		$data = [
			[
				'sort'  => 0,
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
				'sort'  => 2,
				'parent_id' => 0,
				'title' => 'Третий раздел (закрыт)',
				'description' => 'Описание раздела',
				'closed' => 1,
				'created_at' => Carbon::now(),
			],
			[
				'sort'  => 0,
				'parent_id' => 1,
				'title' => 'Первый подраздел',
				'description' => 'Описание раздела',
				'closed' => 0,
				'created_at' => Carbon::now(),
			],
			[
				'sort'  => 1,
				'parent_id' => 1,
				'title' => 'Второй подраздел (закрыт)',
				'description' => 'Описание раздела',
				'closed' => 1,
				'created_at' => Carbon::now(),
			],
		];

		$settings = $this->table('forums');
		$settings->insert($data)->save();
	}
}
