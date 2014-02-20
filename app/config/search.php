<?php if ( ! defined('APP_DIR')) exit('Your request not allowed!');

/**
 * Search Config
 */

/**
 * Search Type
 * 
 * All => "" (empty or null)
 * Cars => "car"
 * Boat and Yachts => "boat"
 * Motorcycles => "moto"
 * ATVs => "atv"
 * RVs => "rv"
 * Trailers => "trailer"
 */
$config['searchType'] = "";

/**
 * Search Country
 * 
 * All => "" (empty or null)
 * United States => "us"
 * Canada => "ca"
 * United Kingdom => "uk"
 */
$config['searchCountry'] = "";

/**
 * Search Make
 * 
 * All => "" (empty or null)
 * E.g. Ford => "Ford"
 */
$config['searchMake'] = "";

/**
 * Search Make
 * 
 * All => "" (empty or null)
 * E.g. Fiesta => "Fiesta"
 */
$config['searchModel'] = "";

/**
 * Search State
 * 
 * All => "" (empty or null)
 * E.g. Alabama => "Alabama"
 */
$config['searchState'] = "";

/**
 * Search City
 * 
 * All => "" (empty or null)
 * E.g. Birmingham => "Birmingham"
 */
$config['searchCity'] = "";