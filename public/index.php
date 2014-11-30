<?php

define('ROOT_PATH', realpath(__DIR__ . '/..'));

require ROOT_PATH . '/vendor/autoload.php';

$app = new Slim\Slim();
$app->notfound(function() use ($app) {
  $app->response()->header('Content-Type', 'application/json');
  $app->halt(404, json_encode((object)[ 'error' => 'Route not found']));
});

$controllersBuilder = new DI\ContainerBuilder();
$controllersBuilder->addDefinitions(ROOT_PATH . '/config/config.php');
$controllersBuilder->addDefinitions(ROOT_PATH . '/config/services.php');
$container = $controllersBuilder->build();
$container->set('app', $app);

$app->add($container->get('middleware.slimjson'));

$routeLocator = new SDO\Dispatcher\RouteLocator($container, $app->request, $app->response);
$callableLocator = new SDO\Container\CallableLocator($container);

$routes = new SDO\Dispatcher\Routes(ROOT_PATH . '/config/routes.php');
foreach($routes as $route) {
  $r = call_user_func_array([$app, $route->method], array_merge(
    [ $route->path ],
    array_map($callableLocator, $route->middleware),
    [ $routeLocator($route->action) ]
  ));

  if ($route->alias) {
    $r->name($route->alias);
  }
}

$app->run();
