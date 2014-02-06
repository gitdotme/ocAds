<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');
// load config files
$loader['helper'] = array(
    'core',
    'seo'
);

// load core classes
$loader['core'] = array(
    'Database',
    'Config',
    'Session',
    'Input',
    'Route',
    'Controller',
    'Model',
    'View',
    'Layout'
);

// load config files
$loader['config'] = array(
    'seo',
    'tags',
    'search',
    'limit'
);