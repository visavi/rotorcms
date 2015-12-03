<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		$data = [
			[
				'login' => 'admin',
				'password' => password_hash('admin', PASSWORD_BCRYPT),
				'email' => 'admin@site.ru',
				'gender' => 'male',
				'level' => 'admin',
				'created_at' => Carbon::now(),
			],
			[
				'login' => 'demo',
				'password' => password_hash('demo', PASSWORD_BCRYPT),
				'email' => 'demo@site.ru',
				'gender' => 'female',
				'level' => 'user',
				'created_at' => Carbon::now(),
			],
		];

		$settings = $this->table('users');
		$settings->insert($data)->save();
	}
}
