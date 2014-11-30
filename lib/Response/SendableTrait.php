<?php

namespace SDO\Response;

/**
 * Send arbitrary arguments to a configured callback
 */
trait SendableTrait
{
  private $callback;

  /**
   * Sets the callback to be invoked via send()
   * 
   * @param callable @callback
   */
  public function setSendCallback(callable $callback) {
    $this->callback = $callback;
  }

  /**
   * Invokes the configured callback
   * 
   * Any given arguments are passed to the callback, and any values returned
   * from the callback are returned.
   * 
   * @param mixed ...
   * @throws \LogicException if no callback has been configured
   * @return mixed
   */
  public function send(...$args) {
    if (!$this->callback) {
      throw new \LogicException('No callback configured for Sendable controller');
    }
    return call_user_func_array($this->callback, $args);
  }
}
