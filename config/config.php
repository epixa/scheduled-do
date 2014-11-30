<?php

return [
  // static config
  'db.host' => DI\env('DB_HOST', 'localhost'),
  'db.name' => DI\env('DB_NAME', 'scheduleddo'),
  'db.user' => DI\env('DB_USER', 'root'),
  'db.pass' => DI\env('DB_PASS', ''),

  'json.status' => DI\env('JSON_STATUS', false),
  'json.override_error' => DI\env('JSON_OVERRIDE_ERROR', true),
  'json.override_notfound' => DI\env('JSON_OVERRIDE_NOTFOUND', false)
];
