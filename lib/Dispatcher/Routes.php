<?php

namespace SDO\Dispatcher;

/**
 * Array-like container that loads routes from a file
 */
class Routes implements \IteratorAggregate, \ArrayAccess
{
  /**
   * @var \ArrayIterator
   */
  protected $routes;

  /**
   * Loads callback from file that is expected to populate routes
   *
   * @param callable $routeFactory
   * @param string $path
   * @throws \RuntimeException if file does not return callable
   */
  public function __construct(callable $routeFactory, $path) {
    $this->routes = new \ArrayIterator();

    $defineRoutes = require $path;
    if (!is_callable($defineRoutes)) {
      throw new \RuntimeException('Route definition is not callable');
    }

    $defineRoutes(call_user_func($routeFactory, $this));
  }

  /**
   * Sets a route on the collection
   * 
   * @param string $scheme
   * @param object $route
   * 
   * @throws \InvalidArgumentException if non-string scheme is given as offset
   */
  public function setRoute($scheme, $route) {
    if (!is_string($scheme)) {
      throw new \InvalidArgumentException(sprintf(
        'Routes must be indexed by a string scheme, %s given', gettype($scheme)
      ));
    }
    $this->routes[$scheme] = $route;
  }

  /**
   * Gets a route from the collection
   *
   * @param string $scheme
   *
   * @throws \OutOfBoundsException if an unindexed scheme is given
   */
  public function getRoute($scheme) {
    if (!isset($this->routes[$scheme])) {
      throw new \OutOfBoundsException('No route indexed that is identified by ' . $scheme);
    }
    return $this->routes[$scheme];
  }

  /**
   * Returns current routes as array-like iterator
   *
   * Implements \IteratorAggregate
   * @link http://php.net/IteratorAggregate
   *
   * @return \ArrayIterator
   */
  public function getIterator() {
    return $this->routes;
  }

  /**
   * Proxies array setter to setRoute()
   *
   * e.g.
   *   $routes[$scheme] = $route;
   *   // is the same as:
   *   $routes->setRoute($scheme, $route);
   *
   * Implements \ArrayAccess
   * @link http://php.net/ArrayAccess
   *
   * @param mixed $offset
   * @param mixed $value
   */
  public function offsetSet($offset, $value) {
    $this->setRoute($offset, $value);
  }

  /**
   * Checks if the current route scheme exists in the collection
   *
   * Implements \ArrayAccess
   * @link http://php.net/ArrayAccess
   *
   * @param string $offset The route scheme to check for
   * @return bool
   */
  public function offsetExists($offset) {
    return isset($this->routes[$offset]);
  }

  /**
   * Removes the route identified by the given scheme from the collection
   *
   * Implements \ArrayAccess
   * @link http://php.net/ArrayAccess
   *
   * @param string $offset The scheme of the route to remove
   */
  public function offsetUnset($offset) {
    unset($this->routes[$offset]);
  }

  /**
   * Proxies array getter to getRoute()
   *
   * e.g.
   *   $routes[$scheme];
   *   // is the same as:
   *   $routes->getRoute($scheme);
   *
   * Implements \ArrayAccess
   * @link http://php.net/ArrayAccess
   *
   * @param mixed $offset
   * @return object
   */
  public function offsetGet($offset) {
    return $this->getRoute($offset);
  }
}
