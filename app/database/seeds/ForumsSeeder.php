<?php

use Phinx\Seed\AbstractSeed;
use Illuminate\Database\Capsule\Manager as Capsule;

class ForumsSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		Capsule::statement('SET FOREIGN_KEY_CHECKS=0;');
		$faker = Faker\Factory::create('ru_RU');

		// Заполнение разделов
		$data = [];

		for ($i = 0; $i < 15; $i++) {
			$data[] = [
				'sort' => $i,
				'parent_id' => $i < 4 ? 0 : rand(1,4),
				'title' => $faker->realText(rand(20, 30)),
				'description' => $faker->realText(rand(30, 50)),
				'closed' => $i%5 ? 0 : 1,
				'created_at' => $faker->dateTimeBetween('-1 month')->format('Y-m-d H:i:s'),
			];
		}

		Capsule::table('forums')->truncate();

		$table = $this->table('forums');
		$table->insert($data)->save();

		// Заполнение тем
		$data = [];

		for ($i = 0; $i < 100; $i++) {
			$data[] = [
				'forum_id' => rand(1, 15),
				'user_id' => rand(1, 5),
				'title' => $faker->realText(rand(25, 50)),
				'note' => $i%3 ? $faker->realText(rand(30, 100)) : '',
				'closed' => $i%5 ? 0 : 1,
				'locked' => $i%6 ? 0 : 1,
				'created_at' => $faker->dateTimeBetween('-1 month')->format('Y-m-d H:i:s'),
			];
		}

		Capsule::table('topics')->truncate();

		$table = $this->table('topics');
		$table->insert($data)->save();

		// Заполнение сообщений
		$data = [];

		for ($i = 0; $i < 1000; $i++) {
			$data[] = [
				'forum_id' => rand(1, 15),
				'topic_id' => rand(1, 50),
				'user_id' => rand(1, 5),
				'text' => $faker->realText(rand(50, 500)),
				'ip' => $faker->ipv4,
				'brow' => App::getUserAgent($faker->userAgent),
				'created_at' => $faker->dateTimeBetween('-1 month')->format('Y-m-d H:i:s'),
			];
		}

		Capsule::table('posts')->truncate();

		$table = $this->table('posts');
		$table->insert($data)->save();

		Capsule::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
