<?php

namespace App\Controllers;

use SDO\Response\SendableTrait;
use App\Traits\DropletsTrait;

class DropletsCtrl {
  use SendableTrait;
  use DropletsTrait;

  public function index() {
    $this->send(['droplets' => $this->droplets->all()]);
  }

  public function get($id) {
    $droplet = $this->droplets->one($id);
    if (!$droplet) return $this->send(404);
    $this->send(['droplet' => $droplet]);
  }
}
