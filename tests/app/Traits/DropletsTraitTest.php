<?php

namespace App\Traits;

class DropletsTraitTest extends \PHPUnit_Framework_TestCase
{
  protected $trait;

  protected function setUp() {
    $this->trait = $this->getMockForTrait('App\\Traits\\DropletsTrait');
  }

  public function testGetSetDropletsService() {
    $service = $this->getMock('App\\Services\\Droplets');

    $this->trait->setDropletsService($service);
    $this->assertSame($this->trait->getDropletsService(), $service);
  }

  /**
   * @expectedException LogicException
   */
  public function testDefaultGetDropletsService() {
    $this->trait->getDropletsService();
  }
}
