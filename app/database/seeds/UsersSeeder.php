<?php

use Phinx\Seed\AbstractSeed;
use Illuminate\Database\Capsule\Manager as Capsule;

class UsersSeeder extends AbstractSeed
{
	//public $priority = 100;
	/**
	 * Run Method.
	 */
	public function run()
	{
		Capsule::statement('SET FOREIGN_KEY_CHECKS=0;');

		$data = [];
		$genders = ['male', 'female'];
		$logins = ['admin', 'moder', 'user', 'guest', 'banned'];

		$faker = Faker\Factory::create('ru_RU');

		foreach ($logins as $login) {

			$gender = $genders[array_rand($genders)];

			$data[] = [
				'login' => $login,
				'password' => password_hash($login, PASSWORD_BCRYPT),
				'email' => $faker->freeEmail,
				'gender' => $gender,
				'level' => $login,
				'name' => $faker->firstName($gender),
				'country' => $faker->country,
				'city' => $faker->city,
				'info' => $faker->realText(rand(30, 100)),
				'phone' => $faker->phoneNumber,
				'birthday' => $faker->date('d-m-Y'),
				'created_at' => $faker->dateTimeBetween('-3 year')->format('Y-m-d H:i:s'),
			];
		}

		Capsule::table('users')->truncate();

		$table = $this->table('users');
		$table->insert($data)->save();

		Capsule::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
