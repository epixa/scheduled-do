<?php

namespace SDO\Database;

/**
 * Get/Set PDO database objects
 */
trait DatabaseTrait
{
  /**
   * @var \PDO
   */
  protected $db;

  /**
   * Sets the current database
   * 
   * @param \PDO $db
   */
  public function setDatabase(\PDO $db) {
    $this->db = $db;
  }

  /**
   * Gets the current database
   * 
   * @throws \LogicException if no database has been set
   * @return \PDO
   */
  public function getDatabase() {
    if (!$this->db) {
      throw new \LogicException('No database set, you must set a PDO instance via setDatabase() first');
    }
    return $this->db;
  }
}
