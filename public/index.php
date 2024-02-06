<?php

declare(strict_types=1);

\define('BASE_PATH', \dirname(__DIR__));

mb_internal_encoding('UTF-8');
error_reporting(-1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

// Optionally load vendor
@include BASE_PATH.'/vendor/autoload.php';
require BASE_PATH.'/sys/autoload.php';
require BASE_PATH.'/bootstrap.php';

require BASE_PATH.'/app/routes.php';

router()->handle(request());
