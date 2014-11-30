<?php

return function($route) {
  $route->route('GET /droplets', 'droplets@index')->alias('list-droplets');
};
