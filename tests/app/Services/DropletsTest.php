<?php

namespace App\Services;

class DropletsTest extends \PHPUnit_Framework_TestCase
{
  protected $droplet;
  protected $droplets;
  protected $db;
  protected $stmt;
  protected $service;

  protected function setUp() {
    $this->droplet = (object)['foo'=>'bar'];
    $this->droplets = [$this->droplet];

    $this->stmt = $this
      ->getMockBuilder("stdClass")
      ->setMethods(['execute', 'fetch', 'fetchAll'])
      ->getMock();

    $pdo = $this
      ->getMockBuilder('Mocks\\PDOMock')
      ->setMethods(['prepare'])
      ->getMock();
    $pdo
      ->method('prepare')
      ->will($this->returnValue($this->stmt));


    $this->service = new Droplets();
    $this->service->setDatabase($pdo);
  }

  public function testAll() {
    $this->stmt
      ->method('fetchAll')
      ->will($this->returnValue($this->droplets));

    $results = $this->service->all();
    $this->assertEquals($results, $this->droplets);
  }

  public function testOneForActualDroplet() {
    $this->stmt
      ->expects($this->once())
      ->method('execute')
      ->with($this->equalTo([123]));

    $this->stmt
      ->expects($this->once())
      ->method('fetch')
      ->will($this->returnValue($this->droplet));

    $droplet = $this->service->one(123);
    $this->assertEquals($droplet, $this->droplet);
  }

  public function testOneForNonExistentDroplet() {
    $this->stmt
      ->expects($this->once())
      ->method('execute')
      ->with($this->equalTo([234]));

    $this->stmt
      ->expects($this->once())
      ->method('fetch')
      ->will($this->returnValue(false));

    $droplet = $this->service->one(234);
    $this->assertEquals($droplet, false);
  }

  public function testGetSetDropletsService() {
    $db = $this->getMock('Mocks\\PDOMock');
    $this->service->setDatabase($db);
    $this->assertSame($this->service->getDatabase(), $db);
  }

  /**
   * @expectedException LogicException
   */
  public function testDefaultGetDatabase() {
    $service = new Droplets();
    $service->getDatabase();
  }
}
