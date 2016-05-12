<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateUsersTable extends AbstractMigration
{
	/**
	 * Change Method.
	 */
	public function change()
	{
		$table = $this->table('users');
		$table->addColumn('login', 'string', ['limit' => 20])
			->addColumn('password', 'string', ['limit' => 128])
			->addColumn('email', 'string', ['limit' => 50])
			->addColumn('gender', 'enum', ['values' => ['male', 'female']])
			->addColumn('level', 'enum', ['values' => ['banned', 'guest', 'user', 'moder', 'admin'], 'default' => 'guest'])
			->addColumn('reset_code', 'string', ['limit' => 50, 'null' => true])
			->addColumn('name', 'string', ['limit' => 20, 'null' => true])
			->addColumn('country', 'string', ['limit' => 30, 'null' => true])
			->addColumn('city', 'string', ['limit' => 50, 'null' => true])
			->addColumn('info', 'text', ['null' => true])
			->addColumn('phone', 'string', ['limit' => 20, 'null' => true])
			->addColumn('site', 'string', ['limit' => 50, 'null' => true])
			->addColumn('icq', 'string', ['limit' => 10, 'null' => true])
			->addColumn('skype', 'string', ['limit' => 32, 'null' => true])
			->addColumn('jabber', 'string', ['limit' => 50, 'null' => true])
			->addColumn('birthday', 'string', ['limit' => 10, 'null' => true])
			->addColumn('newprivat', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
			->addColumn('allforum', 'integer', ['signed' => false, 'default' => 0])
			->addColumn('allguest', 'integer', ['signed' => false, 'default' => 0])
			->addColumn('allcomments', 'integer', ['signed' => false, 'default' => 0])
			->addColumn('themes', 'string', ['limit' => 20, 'null' => true])
			->addColumn('postguest', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
			->addColumn('postnews', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
			->addColumn('postprivat', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
			->addColumn('postforum', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
			->addColumn('themesforum', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
			->addColumn('timezone', 'string', ['limit' => 3, 'default' => 0])
			->addColumn('point', 'integer', ['signed' => false, 'default' => 0])
			->addColumn('money', 'integer', ['signed' => false, 'default' => 0])
			->addColumn('ban', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
			->addColumn('timeban', 'datetime', ['null' => true])
			->addColumn('timelastban', 'datetime', ['null' => true])
			->addColumn('reasonban', 'text', ['null' => true])
			->addColumn('loginsendban', 'string', ['limit' => 20, 'null' => true])
			->addColumn('totalban', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
			->addColumn('explainban', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
			->addColumn('status', 'string', ['limit' => 50, 'null' => true])
			->addColumn('avatar', 'string', ['limit' => 50, 'null' => true])
			->addColumn('picture', 'string', ['limit' => 50, 'null' => true])
			->addColumn('rating', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'default' => 0])
			->addColumn('posrating', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'signed' => false, 'default' => 0])
			->addColumn('negrating', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'signed' => false, 'default' => 0])
			->addColumn('keypasswd', 'string', ['limit' => 20, 'null' => true])
			->addColumn('timepasswd', 'datetime', ['null' => true])
			->addColumn('timebonus', 'datetime', ['null' => true])
			->addColumn('confirmreg', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
			->addColumn('confirmregkey', 'string', ['limit' => 30, 'null' => true])
			->addColumn('secquest', 'string', ['limit' => 50, 'null' => true])
			->addColumn('secanswer', 'string', ['limit' => 40, 'null' => true])
			->addColumn('ipbinding', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
			->addColumn('newchat', 'integer', ['signed' => false, 'default' => 0])
			->addColumn('privacy', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 0])
			->addColumn('apikey', 'string', ['limit' => 32, 'null' => true])
			->addColumn('updated_at', 'timestamp')
			->addColumn('created_at', 'timestamp', ['null' => true])
			->addIndex('login', ['unique' => true])
			->addIndex('email', ['unique' => true])
			->addIndex('level')
			->addIndex('point')
			->addIndex('money')
			->addIndex('rating')
			->create();
	}
}
