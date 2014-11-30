<?php

namespace SDO\Dispatcher;

use Interop\Container\ContainerInterface;

/**
 * Locates route controllers in container
 */
class RouteLocator
{
  protected $container;
  protected $request;
  protected $response;

  /**
   * Constructs a container-aware route locator
   *
   * @param \Interop\Container\ContainerInterface $container
   * @param object $request
   * @param object $response
   */
  public function __construct(ContainerInterface $container, $request, $response) {
    $this->container = $container;
    $this->request = $request;
    $this->response = $response;
  }

  /**
   * Creates a routing function that wraps a controller action
   *
   * The given action name is parsed into a controller object, which is
   * retrieved from the configured container, and a method name that is invoked
   * on that controller.
   *
   * The configured values for request and response are passed as the last two
   * arguments to each action.
   *
   * @see RouteLocator#assertValidName
   *
   * @param string $name Action name in the format <controller>@<action>
   * @return callable
   */
  public function route($name) {
    $this->assertValidName($name);

    return function() use ($name) {
      $pos = strpos($name, '@');
      $controller = substr($name, 0, $pos);
      $action = substr($name, $pos + 1);

      $callback = [$this->container->get('controllers.' . $controller), $action];
      call_user_func($callback, $this->request, $this->response);
    };
  }

  /**
   * Proxies invocation to route()
   *
   * @see RouteLocator#route
   */
  public function __invoke($name) {
    return $this->route($name);
  }


  /**
   * Asserts that name is in the format <controller>@<action>
   *
   * @throws \InvalidArgumentException if route definition is invalid
   */
  protected function assertValidName($name) {
    if (strpos($name, '@') === false) {
      throw new \InvalidArgumentException('Route definition must be in format <controller>@<action>');
    }
  }
}
