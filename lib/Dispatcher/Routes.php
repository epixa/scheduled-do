<?php

namespace SDO\Dispatcher;

class Routes implements \IteratorAggregate, \ArrayAccess {
  protected $routes;

  public function __construct($path) {
    $this->routes = new \ArrayIterator();

    $defineRoutes = require $path;
    if (!is_callable($defineRoutes)) {
      throw new \RuntimeException('Route definition is not callable');
    }

    $defineRoutes(Route::factory($this));
  }

  public function getIterator() {
    return $this->routes;
  }

  public function offsetSet($offset, $value) {
    if (is_null($offset)) {
      $this->routes[] = $value;
    } else {
      $this->routes[$offset] = $value;
    }
  }

  public function offsetExists($offset) {
    return isset($this->routes[$offset]);
  }

  public function offsetUnset($offset) {
    unset($this->routes[$offset]);
  }

  public function offsetGet($offset) {
    return isset($this->routes[$offset]) ? $this->routes[$offset] : null;
  }
}
