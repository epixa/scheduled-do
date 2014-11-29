<?php

namespace App\Controllers;

use SDO\Response\SendableTrait;

class Droplets {
  use SendableTrait;

  public function index($request, $response) {
    $this->send(200, []);
  }
}
