<?php
// set error log
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'].'/error_log');
 
// app directory
define('APP_DIR', 'app');

// environment: development or production
define('ENVIRONMENT', 'production');

// check install
if (is_dir(dirname(__FILE__).'/install'))
{
    header('Location: install');
    exit;
}

// load core
require APP_DIR.'/core/Core.php';

// load bootstrap
require APP_DIR.'/core/Bootstrap.php';

// exec bootstrap
new Bootstrap();