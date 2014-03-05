<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Meta
 */
// site charset
$config['siteCharset'] = 'utf-8';

// site robots
$config['siteRobots'] = 'index, follow';

/**
 * General
 */
// site name
$config['siteName'] = 'ocAds';

// site title
$config['siteTitle'] = 'Used car, boat, atv, trailer, rv classifieds - '.$config['siteName'];

// site desc
$config['siteDesc'] = 'Used and new cars, boats, yachts, atvs, rvs, trailers for sale.';

// site heading
$config['siteHeading'] = 'Welcome to ocAds!';

/**
 * Search
 */
// site title
$config['searchTitle'] = 'Classified ads[ for {query} ][ - {page} ]- '.$config['siteName'];

// site desc
$config['searchDesc'] = 'Classified ads[ for {query}][ - {page}]. [{total}] results found on '.$config['siteName'];

// site heading
$config['searchHeading'] = '[{query} classifieds] - [{total}] results found';

/**
 * Tags
 */
// tags title
$config['tagsTitle'] = 'Classified ads for [{tag}][ - {page} ] - '.$config['siteName'];

// tags desc
$config['tagsDesc'] = 'Classified ads for [{tag}][ - {page}]. [{total}] results found on '.$config['siteName'];

// tags heading
$config['tagsHeading'] = '[{tag} classifieds] - [{total}] results found';