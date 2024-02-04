<?php

session_start();

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/app_config.php';

use Config\Route\Router;

Router::routes();
