<?php

use Phinx\Migration\AbstractMigration;

class CreateDropletsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('droplets');
        $table->addTimestamps()
              ->addColumn('do_id', 'integer')
              ->addColumn('name', 'string')
              ->addColumn('status', 'string')
              ->addColumn('image', 'string')
              ->addColumn('region', 'string')
              ->addColumn('memory', 'integer')
              ->addColumn('vcpus', 'integer')
              ->addColumn('disk', 'integer')
              ->addColumn('user_id', 'integer')
              ->addForeignKey('user_id', 'users', 'id', ['delete' => 'cascade'])
              ->create();
    }
    
    public function up() {}
    public function down() {}
}
