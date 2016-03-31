<?php

use Phinx\Seed\AbstractSeed;
use Illuminate\Database\Capsule\Manager as Capsule;

class GuestbookSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		Guestbook::connection()->query('SET FOREIGN_KEY_CHECKS = 0');
		$faker = Faker\Factory::create('ru_RU');

		$data = [];

		for ($i = 0; $i < 100; $i++) {
			$data[] = [
				'user_id' => $i % rand(7, 10) ? rand(1, 5) : null,
				'text' => $faker->realText(rand(50, 500)),
				'ip' => $faker->ipv4,
				'brow' => App::getUserAgent($faker->userAgent),
				'reply' => $i % rand(7, 10) ? '' : $faker->realText(rand(20, 100)),
				'created_at' => $faker->dateTimeBetween('-1 month')->format('Y-m-d H:i:s'),
			];
		}

		Guestbook::connection()->query('TRUNCATE guestbook');

		$table = $this->table('guestbook');
		$table->insert($data)->save();

		Guestbook::connection()->query('SET FOREIGN_KEY_CHECKS = 1');
	}
}
