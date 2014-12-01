<?php

use Phinx\Migration\AbstractMigration;

class CreateDropletsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     */
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
    
    /**
     * Migrate Up.
     */
    public function up()
    {
    
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
/*
| droplets | CREATE TABLE `droplets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `do_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `memory` int(10) unsigned NOT NULL,
  `vcpus` int(10) unsigned NOT NULL,
  `disk` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `droplets_do_id_unique` (`do_id`),
  KEY `droplets_user_id_foreign` (`user_id`),
  CONSTRAINT `droplets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci |
*/