<?php
define('BASE_PATH', __DIR__);
require 'vendor/autoload.php';

require_once BASE_PATH . '/config.php';
require_once BASE_PATH . '/routes/apiRouter.php';
require_once BASE_PATH . '/routes/webRouter.php';


Flight::start();
