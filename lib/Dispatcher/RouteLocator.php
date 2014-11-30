<?php

namespace SDO\Dispatcher;

class RouteLocator {
  protected $container;
  protected $request;
  protected $response;

  public function __construct($container, $request, $response) {
    $this->container = $container;
    $this->request = $request;
    $this->response = $response;
  }

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

  public function __invoke($name) {
    return $this->route($name);
  }

  protected function assertValidName($name) {
    if (strpos($name, '@') === false) {
      throw new \InvalidArgumentException('Route definition must be in format <controller>@<action>');
    }
  }
}
