<?php

return function($route) {
  return [
    $route->route('GET /droplets', 'droplets@index')->alias('list-droplets')
  ];
};
