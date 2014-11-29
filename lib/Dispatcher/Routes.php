<?php

namespace SDO\Dispatcher;

class Routes implements \IteratorAggregate {
  protected $routes;

  public function __construct($path) {
    $this->routes = new \ArrayIterator();

    $routes = require $path;
    if (!is_array($routes)) {
      throw new \InvalidArgumentException('Route config must return an array: ' . $path);
    }

    foreach($routes as $route => $action) {
      $this->addRoute($route, $action);
    }
  }

  public function addRoute($route, $action) {
    $route = explode(' ', $route);
    $scheme = array_pop($route);
    $method = strtolower(array_pop($route));
    $this->routes[] = (object)[
      'method' => $method,
      'scheme' => $scheme,
      'action' => $action
    ];
  }

  public function getIterator() {
    return $this->routes;
  }
}
