<?php

namespace SDO\Container;

class CallableLocator
{
  protected $container;

  public function __construct($container) {
    $this->container = $container;
  }

  public function getCallableFn($fn) {
    if (is_string($fn)) {
      $fn = $this->container->get($fn);
    }
    if (!is_callable($fn)) {
      throw new \InvalidArgumentException('Function must be callable');
    }
    return $fn;
  }

  public function __invoke($name) {
    return $this->getCallableFn($name);
  }
}
