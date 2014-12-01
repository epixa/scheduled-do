<?php

namespace SDO\Dispatcher;

use \InvalidArgumentException;
use \OutOfBoundsException;
use \LogicException;

class Route {
  protected $scheme;
  protected $method;
  protected $path;
  protected $action;
  protected $alias;
  protected $middleware = [];

  public static function factory($scheme = null, $action = null, $alias = null, $middleware = []) {
    return new Route($scheme, $action, $alias, $middleware);
  }

  public function __get($property) {
    if (!in_array($property, ['scheme', 'method', 'path', 'action', 'alias', 'middleware'])) {
      throw new OutOfBoundsException('Route has no property ' . $property);
    }
    return $this->$property;
  }

  public function route($scheme, $action) {
    return self::factory(
      $scheme,
      $action,
      $this->alias,
      $this->middleware
    );
  }

  public function alias($alias) {
    return self::factory(
      $this->scheme, $this->action,
      $alias,
      $this->middleware
    );
  }

  public function with($middleware) {
    return self::factory(
      $this->scheme,
      $this->action,
      $this->alias,
      array_merge($this->middleware, [$middleware])
    );
  }


  protected function __construct($scheme = null, $action = null, $alias = null, $middleware = []) {
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
