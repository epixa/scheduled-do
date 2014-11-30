<?php

namespace SDO\Container;

class CallableLocatorTest extends \PHPUnit_Framework_TestCase
{
  protected $locator;

  protected function setUp() {
    $container = $this->getMock('Interop\\Container\\ContainerInterface');

    // all retrieved functions from container should return their own name
    // so we can ensure the container is accessed with the given input
    $container->method('get')
              ->will($this->returnCallback(function($arg) {
                return function() use ($arg) {
                  return $arg;
                };
              }));

    $this->locator = new CallableLocator($container);
  }

  public function testGetCallableFnWithFunction() {
    $input = function() {};
    $fn = $this->locator->getCallableFn($input);
    $this->assertSame($input, $fn);
  }

  public function testGetCallableFnWithName() {
    $fn = $this->locator->getCallableFn('foo');
    $this->assertEquals($fn(), 'foo');
  }

  public function testInvokeWithFunction() {
    $this->testGetCallableFnWithFunction();
  }

  public function testInvokeWithName() {
    $this->testGetCallableFnWithName();
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testGetCallableFnWithInvalidFn() {
    $this->locator->getCallableFn(7);
  }
}
