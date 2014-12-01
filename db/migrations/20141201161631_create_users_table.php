<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addTimestamps()
              ->addColumn('email', 'string')
              ->addColumn('password', 'string')
              ->addIndex(['email'], ['unique' => true])
              ->create();
    }
    
    public function up() {}
    public function down() {}
}
