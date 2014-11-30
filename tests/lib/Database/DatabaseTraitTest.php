<?php

namespace SDO\Database;

class DatabaseTraitTest extends \PHPUnit_Framework_TestCase
{
  protected $trait;

  protected function setUp() {
    $this->trait = $this->getMockForTrait('SDO\\Database\\DatabaseTrait');
  }

  public function testGetSetDatabase() {
    $db = $this->getMockBuilder('Mocks\\PDOMock')->getMock();
    $this->trait->setDatabase($db);
    $this->assertSame($this->trait->getDatabase(), $db);
  }

  /**
   * @expectedException LogicException
   */
  public function testDefaultGetDatabase() {
    $this->trait->getDatabase();
  }
}
