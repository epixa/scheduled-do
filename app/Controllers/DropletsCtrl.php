<?php

namespace App\Controllers;

use SDO\Response\SendableTrait;
use App\Traits\DropletsTrait;

/**
 * Control request/response processing for droplet actions
 */
class DropletsCtrl
{
  use SendableTrait;
  use DropletsTrait;

  /**
   * Gets all droplets
   */
  public function index() {
    $this->send(['droplets' => $this->droplets->all()]);
  }

  /**
   * Gets a specific droplet based on the given id
   *
   * @param int $id
   */
  public function get($id) {
    $droplet = $this->droplets->one($id);
    if (!$droplet) return $this->send(404);
    $this->send(['droplet' => $droplet]);
  }
}
