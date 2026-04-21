<?php

return [
  'name'   => 'edocs_session',
  'path'   => '/',
  'domain' => $_SERVER['HTTP_HOST'],
  'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'),
  'min'    => 2400,
  'max'    => 3600,
  'debug'  => false,
];