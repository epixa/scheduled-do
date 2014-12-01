<?php

namespace App\Traits;

use App\Services\Droplets;

/**
 * Get/Set droplets service
 */
trait DropletsTrait
{
  /**
   * @var \App\Services\Droplets
   */
  protected $droplets;

  /**
   * Sets the droplets service
   * 
   * @param \App\Services\Droplets $service
   */
  public function setDropletsService(Droplets $service) {
    $this->droplets = $service;
  }

  /**
   * Gets the configured droplets service
   * 
   * @throws \LogicException if no service has been configured
   * @return \App\Services\Droplets
   */
  public function getDropletsService() {
    if (!$this->droplets) {
      throw new \LogicException('No droplets service set, you must configure setDropletsService() first');
    }
    return $this->droplets;
  }
}
