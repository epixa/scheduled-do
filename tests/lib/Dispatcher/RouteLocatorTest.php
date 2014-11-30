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

    $this->controller = $this->getMockBuilder('stdClass')
                             ->setMethods(['bar'])
                             ->getMock();
    $this->request = $this->getMock('stdClass');
    $this->response = $this->getMock('stdClass');

    // all retrieved functions from container should return their own name
    // so we can ensure the container is accessed with the given input
    $container->method('get')
              ->will($this->returnValue($this->controller));

    $this->locator = new RouteLocator($container, $this->request, $this->response);
  }

  public function testRouteReturnsFnThatInvokesCtrlAction() {
    $this->controller->expects($this->once())
                     ->method('bar')
                     ->with(
                       $this->equalTo($this->request),
                       $this->equalTo($this->response)
                     );
    $fn = $this->locator->route('foo@bar');
    $fn();
  }

  public function testInvokeReturnsFnThatInvokesCtrlAction() {
    $this->testRouteReturnsFnThatInvokesCtrlAction();
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testRouteWithInvalidName() {
    $this->locator->route('invalidname');
  }
}
