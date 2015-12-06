<?php

use Phinx\Seed\AbstractSeed;

class SettingsSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		$data = [
			[
				'name'  => 'email',
				'value' => 'visavi.net@mail.ru',
			],
			[
				'name'  => 'admin',
				'value' => 'Админ',
			],
			[
				'name'  => 'sitelink',
				'value' => 'rotorcms.ll',
			],
			[
				'name'  => 'sitename',
				'value' => 'Сайт на движке Rotor',
			],
			[
				'name'  => 'sitetitle',
				'value' => 'Rotor 5.0',
			],
			[
				'name'  => 'version',
				'value' => '5.0',
			],
			[
				'name'  => 'guestbook_per_page',
				'value' => 10,
			],
			[
				'name'  => 'users_per_page',
				'value' => 10,
			],
			[
				'name'  => 'topics_per_page',
				'value' => 10,
			],
			[
				'name'  => 'posts_per_page',
				'value' => 10,
			],
			[
				'name'  => 'news_per_page',
				'value' => 10,
			],
			[
				'name'  => 'description',
				'value' => 'Описание',
			],
			[
				'name'  => 'keywords',
				'value' => 'Ключевые слова',
			],
		];

		Setting::connection()->query('TRUNCATE settings');
		$table = $this->table('settings');
		$table->insert($data)->save();
	}
}
