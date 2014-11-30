<?php

namespace SDO\Dispatcher;

class MiddlewareLocator {
  protected $container;

  public function __construct($container) {
    $this->container = $container;
  }

  public function middleware($fn) {
    if (is_string($fn)) {
      $fn = $this->container->get($fn);
    }
    return $fn;
  }

  public function __invoke($name) {
    return $this->middleware($name);
  }
}
