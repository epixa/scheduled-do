<?php

namespace SDO\Response;

trait SendableTrait {
  private $callback;

  public function setSendCallback(callable $callback) {
    $this->callback = $callback;
  }

  public function send(...$args) {
    if (!$this->callback) {
      throw new \RuntimeException('No callback configured for Sendable controller');
    }
    return call_user_func_array($this->callback, $args);
  }
}
