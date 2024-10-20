<?php
  $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(sprintf('%s/app', __DIR__)));
  foreach ($iterator as $file) {
    if ($file->isFile() && pathinfo($file->getFilename(), PATHINFO_EXTENSION) === 'php') {
      require_once $file->getPathname();
    }
  }
