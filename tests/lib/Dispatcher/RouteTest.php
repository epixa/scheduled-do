<?php

namespace SDO\Dispatcher;

class RouteTest extends \PHPUnit_Framework_TestCase
{
  public function testFactoryReturnsNewRoute() {
    $route = Route::factory();
    $this->assertInstanceOf(Route::class, $route);
  }

  public function testFactorySetsSchemeAndAction() {
    $route = Route::factory('GET /foo', 'foo');
    $this->assertEquals($route->scheme, 'GET /foo');
    $this->assertEquals($route->action, 'foo');
  }

  public function testFactorySetsMethodAndPathFromScheme() {
    $route = Route::factory('GET /foo', 'foo');
    $this->assertEquals($route->path, '/foo');
    $this->assertEquals($route->method, 'get');
  }

  public function testFactorySetsAlias() {
    $route = Route::factory(null, null, 'getfoo');
    $this->assertEquals($route->alias, 'getfoo');
  }

  public function testFactorySetsMiddleware() {
    $route = Route::factory(null, null, null, ['mymid']);
    $this->assertEquals($route->middleware, ['mymid']);
  }


  public function testRouteReturnsNewRoute() {
    $route = Route::factory();
    $returned = $route->route();
    $this->assertInstanceOf(Route::class, $returned);
    $this->assertNotSame($route, $returned);
  }

  public function testRouteWithNoArgsResetsSchemeAndAction() {
    $route = Route::factory('GET /foo', 'foo');
    $returned = $route->route();
    $this->assertNull($returned->scheme);
    $this->assertNull($returned->action);
  }

  public function testRouteSetsSchemeAndAction() {
    $route = Route::factory('GET /foo', 'foo');
    $returned = $route->route('GET /bar', 'bar');
    $this->assertEquals($returned->scheme, 'GET /bar');
    $this->assertEquals($returned->action, 'bar');
  }

  public function testRouteInheritsAlias() {
    $route = Route::factory(null, null, 'getfoo');
    $returned = $route->route();
    $this->assertEquals($returned->alias, 'getfoo');
  }

  public function testRouteInheritsMiddleware() {
    $route = Route::factory(null, null, null, ['mymid']);
    $returned = $route->route();
    $this->assertEquals($returned->middleware, ['mymid']);
  }


  public function testAliasReturnsNewRoute() {
    $route = Route::factory();
    $returned = $route->alias('somealias');
    $this->assertNull($route->alias);
    $this->assertInstanceOf(Route::class, $returned);
    $this->assertNotSame($route, $returned);
  }

  public function testAliasSetsAlias() {
    $route = Route::factory();
    $returned = $route->alias('somealias');
    $this->assertNull($returned->alias(null)->alias);
    $this->assertEquals($returned->alias, 'somealias');
  }

  public function testAliasWithNoArgsResetsAlias() {
    $route = Route::factory(null, null, 'somealias');
    $returned = $route->alias();
    $this->assertNull($returned->alias);
  }

  public function testAliasInheritsSchemeAndAction() {
    $route = Route::factory('GET /foo', 'foo');
    $returned = $route->alias('somealias');
    $this->assertEquals($returned->scheme, 'GET /foo');
    $this->assertEquals($returned->action, 'foo');
  }

  public function testAliasInheritsMiddleware() {
    $route = Route::factory(null, null, null, ['mymid']);
    $returned = $route->alias('somealias');
    $this->assertEquals($returned->middleware, ['mymid']);
  }


  public function testWithReturnsNewRoute() {
    $route = Route::factory();
    $returned = $route->with('mymid');
    $this->assertEquals($route->middleware, []);
    $this->assertInstanceOf(Route::class, $returned);
    $this->assertNotSame($route, $returned);
  }

  public function testWithMergesMiddleware() {
    $route = Route::factory(null, null, null, ['mymid']);
    $two = function() {};
    $returned = $route->with('one')->with($two);
    $this->assertEquals($returned->middleware, ['mymid', 'one', $two]);
  }

  public function testWithInheritsSchemeAndAction() {
    $route = Route::factory('GET /foo', 'foo');
    $returned = $route->with('mymid');
    $this->assertEquals($returned->scheme, 'GET /foo');
    $this->assertEquals($returned->action, 'foo');
  }

  public function testWithInheritsAlias() {
    $route = Route::factory(null, null, 'getfoo');
    $returned = $route->with('mymid');
    $this->assertEquals($returned->alias, 'getfoo');
  }


  /**
   * @expectedException InvalidArgumentException
   */
  public function testFactoryErrorsWithOnlyScheme() {
    Route::factory('GET /foo');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testFactoryErrorsWithOnlyAction() {
    Route::factory(null, 'foo');
  }
}
