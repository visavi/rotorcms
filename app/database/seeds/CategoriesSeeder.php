<?php

use Phinx\Seed\AbstractSeed;

class CategoriesSeeder extends AbstractSeed
{
	/**
	 * Run Method.
	 */
	public function run()
	{
		Category::connection()->query('SET FOREIGN_KEY_CHECKS = 0');
		$faker = Faker\Factory::create('ru_RU');

		$data = [];

		for ($i = 0; $i < 10; $i++) {
			$name = $faker->realText(rand(25, 35));
			$data[] = [
				'sort' => $i,
				'parent_id' => 0,
				'name' => $name,
				'slug' => App::slugify($name),
				'description' => $faker->realText(rand(200, 500)),
				'created_at' => $faker->dateTimeBetween('-1 month')->format('Y-m-d H:i:s'),
			];
		}

		Category::connection()->query('TRUNCATE categories');

		$table = $this->table('categories');
		$table->insert($data)->save();

		Category::connection()->query('SET FOREIGN_KEY_CHECKS = 1');
	}
}
