<?php

namespace SDO\Database;

class SendableTraitTest extends \PHPUnit_Framework_TestCase
{
  protected $trait;

  protected function setUp() {
    $this->trait = $this->getMockForTrait('SDO\\Response\\SendableTrait');
  }

  public function testSendPassesArguments() {
    $passedArgs = [];
    $this->trait->setSendCallback(function($one, $two) use (&$passedArgs) {
      $passedArgs[] = $one;
      $passedArgs[] = $two;
    });
    $this->trait->send(1, 2);
    $this->assertEquals($passedArgs, [1, 2]);
  }

  public function testSendReturnsValue() {
    $this->trait->setSendCallback(function() {
      return 'foo';
    });
    $returned = $this->trait->send();
    $this->assertEquals($returned, 'foo');
  }

  /**
   * @expectedException LogicException
   */
  public function testDefaultSend() {
    $this->trait->send();
  }
}
