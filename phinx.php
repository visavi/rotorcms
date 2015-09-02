<?php
return [
	'paths' => [
		'migrations' => 'app/database/migrations',
	],
	'environments' => [
		'default_migration_table' => 'migrations',
		'default_database' => 'default',
		'default' => [
			'adapter' => 'mysql',
			'host' => $_ENV['DB_HOST'],
			'name' => $_ENV['DB_DATABASE'],
			'user' => $_ENV['DB_USERNAME'],
			'pass' => $_ENV['DB_PASSWORD'],
		]
	]
];
