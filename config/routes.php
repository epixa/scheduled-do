<?php

return function($route) {
  return [
    $route->route('GET /droplets', 'droplets@index')->alias('list-droplets'),
    $route->route('GET /droplets/:id', 'droplets@get')->alias('get-droplet')
  ];
};
