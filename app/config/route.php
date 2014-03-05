<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

// item
$route['itemLink'] = array(
    'route' => 'rd/{id}',
    'method' => 'item@index'
);

// search
$route['searchLink'] = array(
    'route' => 'search',
    'method' => 'search@index'
);

// rss
$route['rssLink'] = array(
    'route' => 'rss',
    'method' => 'search@rss'
);

// tags
$route['tagLink'] = array(
    'route' => 'tag/{tag}',
    'method' => 'search@index'
);

$route['tagPageLink'] = array(
    'route' => 'tag/{tag}/{page}',
    'method' => 'search@index'
);

// static content
$route['aboutUsLink'] = array(
    'route' => 'about_us',
    'method' => 'content@about'
);

$route['privacyLink'] = array(
    'route' => 'privacy_policy',
    'method' => 'content@privacy'
);

$route['termsLink'] = array(
    'route' => 'terms_of_use',
    'method' => 'content@terms'
);

$route['contactLink'] = array(
    'route' => 'contact',
    'method' => 'content@contact'
);

// captcha
$route['captchaLink'] = array(
    'route' => 'captcha',
    'method' => 'captcha@index'
);