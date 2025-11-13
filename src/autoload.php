<?php
DEFINE('BASE_PATH', __DIR__);
spl_autoload_register(function ($class) {
  $path = (BASE_PATH . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php');
  if (file_exists($path)) {
    require_once $path;
  } else {
    error_log(sprintf("Autoload failed: %s => %s", $class, $path));
  }
});
