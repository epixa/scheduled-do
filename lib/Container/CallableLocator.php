<?php

namespace SDO\Container;

use Interop\Container\ContainerInterface;

/**
 * Locates callable objects in container
 */
class CallableLocator
{
  protected $container;

  /**
   * Constructs a container-aware locator
   * 
   * @param \Interop\Container\ContainerInterface $container
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * Locates and returns the given callable object
   * 
   * If a string is given, the function identified by that name is retrieved
   * from the container. If a callable object is given, then it is returned
   * without interference.
   * 
   * @param string|callable $fn
   * @throws \InvalidArgumentException if the function is not callable
   * @return callable
   */
  public function getCallableFn($fn) {
    if (is_string($fn)) {
      $fn = $this->container->get($fn);
    }
    if (!is_callable($fn)) {
      throw new \InvalidArgumentException('Function must be callable');
    }
    return $fn;
  }

  /**
   * Proxies invocation to getCallableFn()
   * 
   * @see CallableLocator#getCallableFn
   */
  public function __invoke($name) {
    return $this->getCallableFn($name);
  }
}
