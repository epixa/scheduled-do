<?php

namespace SDO\Dispatcher;

use \InvalidArgumentException;
use \OutOfBoundsException;
use \LogicException;

/**
 * Immutable representation of a route
 *
 * @property-read null|string $scheme
 * @property-read null|string $action
 * @property-read null|string $alias
 * @property-read array $middleware
 */
class Route
{
  protected $scheme;
  protected $method;
  protected $path;
  protected $action;
  protected $alias;
  protected $middleware = [];


  /**
   * Creates an instance of self with the given data
   *
   * Note: Route instances are immutable once created
   *
   * If either $scheme or $action is present, then both must be present.
   *
   * @param null|string $scheme
   * @param null|string $action
   * @param null|string $alias
   * @param array $middleware
   * @return Route
   */
  public static function factory($scheme = null, $action = null, $alias = null, $middleware = []) {
    return new Route($scheme, $action, $alias, $middleware);
  }

  /**
   * Exposes protected properties as read-only public properties
   * @link http://php.net/__get
   *
   * @throws \OutOfBoundsException if property name is not whitelisted
   * @return mixed
   */
  public function __get($property) {
    if (!in_array($property, ['scheme', 'method', 'path', 'action', 'alias', 'middleware'])) {
      throw new OutOfBoundsException('Route has no property ' . $property);
    }
    return $this->$property;
  }

  /**
   * Creates a new route with the given scheme and action
   *
   * This route will be a child of the current route, which means it will
   * inherit the alias and middleware values from the current route.
   *
   * @param null|string $scheme
   * @param null|string $action
   * @return Route
   */
  public function route($scheme = null, $action = null) {
    return self::factory(
      $scheme,
      $action,
      $this->alias,
      $this->middleware
    );
  }

  /**
   * Creates a new route with the given alias
   *
   * This route will be a child of the current route, which means it will
   * inherit the scheme, action, and middleware values from the current route.
   *
   * @param null|string $alias
   * @return Route
   */
  public function alias($alias) {
    return self::factory(
      $this->scheme,
      $this->action,
      $alias,
      $this->middleware
    );
  }

  /**
   * Creates a new route with the given middleware
   *
   * This route will be a child of the current route, which means it will
   * inherit the scheme, action, alias, and middleware values from the current
   * route. The given middleware is appended to the end of the existing
   * middleware.
   *
   * @param string|callable $middleware
   * @return Route
   */
  public function with($middleware) {
    return self::factory(
      $this->scheme,
      $this->action,
      $this->alias,
      array_merge($this->middleware, [$middleware])
    );
  }


  /**
   * @throws \InvalidArgumentException if value is not a string
   */
  protected function assertValidAlias($alias) {
    if (!is_string($alias)) {
      throw new InvalidArgumentException(sprintf('Alias must be string, %s given', gettype($alias)));
    }
  }

  /**
   * @throws \InvalidArgumentException if value is not a string or callable
   */
  protected function assertValidMiddleware($middleware) {
    if (!is_string($middleware) && !is_callable($middleware)) {
      throw new InvalidArgumentException('Middleware must be a string or callable');
    }
  }

  /**
   * @throws \InvalidArgumentException if value is not a string or is not in
   *                                   the format: <method> <path>
   */
  protected function assertValidScheme($scheme) {
    if (!is_string($scheme)) {
      throw new InvalidArgumentException(sprintf('Scheme must be string, %s given', gettype($scheme)));
    }
    if (!preg_match('/[a-z] \/.*/i', $scheme)) {
      throw new InvalidArgumentException('Invalid route scheme: ' . $scheme);
    }
  }

  /**
   * @throws \InvalidArgumentException if value is not a string
   */
  protected function assertValidAction($action) {
    if (!is_string($action)) {
      throw new InvalidArgumentException(sprintf('Action must be string, %s given', gettype($action)));
    }
  }


  /**
   * Constructs a new route with the given data
   *
   * @param null|string $scheme
   * @param null|string $action
   * @param null|string $alias
   * @param array $middleware
   */
  private function __construct($scheme = null, $action = null, $alias = null, $middleware = []) {
    if ($scheme || $action) {
      $this->setScheme($scheme);
      $this->setAction($action);
    }

    if ($alias) {
      $this->setAlias($alias);
    }

    if ($middleware) {
      foreach($middleware as $m) {
        $this->addMiddleware($m);
      }
    }
  }

  /**
   * Sets the scheme
   *
   * The path and method are also set based on the scheme itself
   */
  private function setScheme($scheme) {
    $this->assertValidScheme($scheme);
    $this->scheme = $scheme;

    $segments = explode(' ', $scheme);
    $this->path = array_pop($segments);
    $this->method = strtolower(array_pop($segments));
  }

  private function setAction($action) {
    $this->assertValidAction($action);
    $this->action = $action;
  }

  private function setAlias($alias) {
    $this->assertValidAlias($alias);
    $this->alias = $alias;
  }

  private function addMiddleware($middleware) {
    $this->assertValidMiddleware($middleware);
    $this->middleware[] = $middleware;
  }
}
