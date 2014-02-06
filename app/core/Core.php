<?php if (strpos($_SERVER['PHP_SELF'], basename(__FILE__))) exit('Your request not allowed!');

// check app dir if defined
if ( ! defined('APP_DIR'))
{
    define('APP_DIR', 'app');
}

// check app dir if defined
if ( ! defined('ENVIRONMENT'))
{
    define('ENVIRONMENT', 'development');
}

// set error reporting by environment
if (ENVIRONMENT == 'development')
{
    error_reporting(E_ALL);
}
else if (ENVIRONMENT == 'production')
{
    error_reporting(0);
}

// load loader
require APP_DIR.'/core/Loader.php';

// exec loader
new Loader();