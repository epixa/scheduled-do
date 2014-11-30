<?php

namespace SDO\Dispatcher;

class RouteLocatorTest extends \PHPUnit_Framework_TestCase
{
  protected $controller;
  protected $request;
  protected $response;
  protected $locator;

  protected function setUp() {
    $container = $this->getMock('Interop\\Container\\ContainerInterface');

    // single mock controller with a `bar` action
    $this->controller = $this->getMockBuilder('stdClass')
                             ->setMethods(['bar'])
                             ->getMock();
    $this->request = $this->getMock('stdClass');
    $this->response = $this->getMock('stdClass');

    // force the container mock to return the controller mock
    $container->method('get')
              ->will($this->returnValue($this->controller));

    $this->locator = new RouteLocator($container, $this->request, $this->response);
  }

  public function testRouteToCtrlWithNoArgsAction() {
    $this->controller->expects($this->once())
                     ->method('bar')->with(
                       $this->equalTo($this->request),
                       $this->equalTo($this->response)
                     );
    $fn = $this->locator->route('foo@bar');
    $fn();
  }

  public function testRouteToCtrlWithArgsAction() {
    $this->controller->expects($this->once())
                     ->method('bar')
                     ->with(
                       $this->equalTo('one'),
                       $this->equalTo(2),
                       $this->equalTo($this->request),
                       $this->equalTo($this->response)
                     );
    $fn = $this->locator->route('foo@bar');
    $fn('one', 2);
  }

  public function testInvokeToCtrlWithNoArgsAction() {
    $this->controller->expects($this->once())
                     ->method('bar')->with(
                       $this->equalTo($this->request),
                       $this->equalTo($this->response)
                     );
    $locator = $this->locator;
    $fn = $locator('foo@bar');
    $fn();
  }

  public function testInvokeToCtrlWithArgsAction() {
    $this->controller->expects($this->once())
                     ->method('bar')->with(
                       $this->equalTo('one'),
                       $this->equalTo(2),
                       $this->equalTo($this->request),
                       $this->equalTo($this->response)
                     );
    $locator = $this->locator;
    $fn = $locator('foo@bar');
    $fn('one', 2);
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testRouteWithInvalidName() {
    $this->locator->route('invalidname');
  }
}
