<?php

/**
 * 
 * DEV-CORE-PHP
 * -----------------------------------------------
 * Author- Tridev Sharma
 * 2022
 * -----------------------------------------------
 */

/**
 * system required variables
 */
define('DEV_CORE_PHP', microtime(true));

define('_BASE_DIR_', __DIR__);

 /**
  * load vendors
  */
require __DIR__ . '/vendor/autoload.php';

/**
 * handle everything
 */

require_once __DIR__ . '/core/App.php';

$app = new App;

/**
 * here you go............
 */
$app->start();
