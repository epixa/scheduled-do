<?php

namespace App\Services;

use SDO\Database\DatabaseTrait;

/**
 * Storage service for droplets
 */
class Droplets
{
  use DatabaseTrait;

  /**
   * Retrieve all droplets from the database
   *
   * Order is newest first
   *
   * @return array
   */
  public function all() {
    $sql = 'select * from droplets order by created_at desc';
    $stmt = $this->getDatabase()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  /**
   * Retrieve a single droplet from the database
   *
   * @param int $id The id of the droplet to retrieve
   * @return object
   */
  public function one($id) {
    $sql = 'select * from droplets where id = ?';
    $stmt = $this->getDatabase()->prepare($sql);
    $stmt->execute([ $id ]);
    return $stmt->fetch();
  }
}
