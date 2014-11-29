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
$container = $controllersBuilder->build();
$container->set('app', $app);

$app->add($container->get('middleware.slimjson'));

$defineRoute = new SDO\Dispatcher\RouteDefiner($container, $app->request, $app->response);

$routes = new SDO\Dispatcher\Routes(ROOT_PATH . '/config/routes.php');
foreach($routes as $route) {
  call_user_func([$app, $route->method], $route->scheme, $defineRoute($route->action));
}

$app->run();
