<?php

namespace SDO\Dispatcher;

use \InvalidArgumentException;
use \OutOfBoundsException;
use \LogicException;

class Route {
  protected $container;
  protected $scheme;
  protected $method;
  protected $path;
  protected $action;
  protected $alias;
  protected $middleware = [];

  public static function factory($container, $scheme = null, $action = null, $alias = null, $middleware = []) {
    return new Route($container, $scheme, $action, $alias, $middleware);
  }

  public function __get($property) {
    if (!in_array($property, ['scheme', 'method', 'path', 'action', 'alias', 'middleware'])) {
      throw new OutOfBoundsException('Route has no property ' . $property);
    }
    return $this->$property;
  }

  public function route($scheme, $action) {
    return self::factory(
      $this->container,
      $scheme,
      $action,
      null,
      $this->middleware
    );
  }

  public function alias($alias) {
    $this->assertDispatchable();
    return self::factory(
      $this->container,
      $this->scheme, $this->action,
      $this->alias,
      $this->middleware
    );
  }

  public function with($middleware) {
    return self::factory(
      $this->container,
      $this->scheme,
      $this->action,
      null,
      array_merge($this->middleware, [$middleware])
    );
  }

  public function isDispatchable() {
    return $this->scheme && $this->action;
  }


  protected function __construct($container, $scheme = null, $action = null, $alias = null, $middleware = []) {
    $this->assertValidContainer($container);
    $this->container = $container;

    if ($scheme || $action) {
      $this->setScheme($scheme);
      $this->setAction($action);
    }

    if ($alias) {
      $this->setAlias($alias);
    }

    if ($middleware) {
      foreach($middleware as $m) {
        $this->assertValidMiddleware($m);
        $this->middleware[] = $m;
      }
    }

    if ($this->isDispatchable()) {
      $this->container[$this->scheme] = $this;
    }
  }

  protected function setScheme($scheme) {
    $this->assertValidScheme($scheme);
    $this->scheme = $scheme;

    $segments = explode(' ', $scheme);
    $this->path = array_pop($segments);
    $this->method = strtolower(array_pop($segments));
  }

  protected function setAction($action) {
    $this->assertValidAction($action);
    $this->action = $action;
  }

  protected function setAlias($alias) {
    $this->assertValidAlias($alias);
    $this->alias = $alias;
  }

  protected function assertValidContainer($container) {
    if (!is_array($container) && !($container instanceof \ArrayAccess)) {
      throw new InvalidArgumentException('Container must be an array or implement ArrayAccess');
    }
  }

  protected function assertDispatchable() {
    if (!$this->isDispatchable()) {
      throw new LogicException('Defined route is not dispatchable');
    }
  }

  protected function assertValidAlias($alias) {
    if (!is_string($alias)) {
      throw new InvalidArgumentException(sprintf('Alias must be string, %s given', gettype($alias)));
    }
  }

  protected function assertValidMiddleware($middleware) {
    if (!is_string($middleware) && !is_callable($middleware)) {
      throw new InvalidArgumentException('Middleware must be a string or callable');
    }
  }

  protected function assertValidScheme($scheme) {
    if (!is_string($scheme)) {
      throw new InvalidArgumentException(sprintf('Scheme must be string, %s given', gettype($scheme)));
    }
    if (!preg_match('/[a-zA-Z] \/.*/i', $scheme)) {
      throw new InvalidArgumentException('Invalid route scheme: ' . $scheme);
    }
  }

  protected function assertValidAction($action) {
    if (!is_string($action)) {
      throw new InvalidArgumentException(sprintf('Action must be string, %s given', gettype($action)));
    }
  }
}
