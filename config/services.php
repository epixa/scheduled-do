<?php

return [
  // controllers
  'controllers.droplets' => DI\object('App\\Controllers\\DropletsCtrl')
    ->method('setSendCallback', DI\link('app.render')),


  // services
  'services.droplets' => DI\object('App\\Services\\Droplets')
    ->method('setDatabase', DI\link('db')),


  // db
  'db' => DI\factory(function($container) {
    $host = $container->get('db.host');
    $name = $container->get('db.name');
    $user = $container->get('db.user');
    $pass = $container->get('db.pass');

    $dsn = sprintf('mysql:%s;dbname=%s', $host, $name);

    return new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
  }),


  // app
  'app.render' => DI\factory(function($container) {
    return [$container->get('app'), 'render'];
  }),


  // middleware
  'middleware.slimjson' => DI\factory(function($container) {
    return new SlimJson\Middleware([
      'json.status' => $container->get('json.status'),
      'json.override_error' => $container->get('json.override_error'),
      'json.override_notfound' => $container->get('json.override_notfound')
    ]);
  })
];
