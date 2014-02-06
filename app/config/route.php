<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

// item
$route['rd/{id}'] = 'item@index';

// search
$route['search'] = 'search@index';

// rss
$route['rss'] = 'search@rss';

// tags
$route['tag/{tag}'] = 'search@index';
$route['tag/{tag}/{page}'] = 'search@index';

// static content
$route['about_us'] = 'content@about';
$route['privacy_policy'] = 'content@privacy';
$route['terms_of_use'] = 'content@terms';
$route['contact'] = 'content@contact';

// captcha
$route['captcha'] = 'captcha@index';