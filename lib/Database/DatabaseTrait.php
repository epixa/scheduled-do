<?php

namespace SDO\Database;

use PDO;

trait DatabaseTrait {
  protected $db;

  public function setDatabase(PDO $db) {
    $this->db = $db;
  }
}
