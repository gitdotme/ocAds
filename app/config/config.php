<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Config
 */

// api key
$config['apiKey'] = '';

// base url
$config['baseURL'] = '';

// sender email
$config['senderName'] = '';
$config['senderEmail'] = '';

// contact email
$config['contactEmail'] = '';

// default controller
$config['defaultController'] = 'home';

// compress output
$config['compressOutput'] = FALSE;

/**
 * Log Threshold
 * 
 * 1 = debug
 * 2 = error
 * 3 = all
 */
$config['logThreshold'] = 1;