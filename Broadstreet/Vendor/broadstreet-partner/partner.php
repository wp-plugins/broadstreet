<?php
/**
 * This is the Broadstreet partner configuration file.
 */

/** 
 * What is your partner name? It doesn't make sense to use someone
 *  else's partner name, unless you want to make them rich.
 */
define('BROADSTREET_PARTNER_NAME', 'wpplugin');

/**
 * Options are one of:
 *  wordpress, website
 */
define('BROADSTREET_PARTNER_TYPE', 'wordpress');

/**
 * This is the name of the folder that sites in wp-content/plugins for
 * the plugin which is be integrated into. We try to detect this automatically,
 * but use this as a fallback.
 */
define('BROADSTREET_PARTNER_PLUGIN', 'broadstreet');

/**
 * Should we show the user the ad code in the last step? If not, we'll try
 *  to place the ad code in the selector specified in the
 *  BROADSTREET_AD_TAG_SELECTOR setting
 */
if(!defined('BROADSTREET_SHOW_CODE')) define('BROADSTREET_SHOW_CODE', false);


/**
 * The path from the main plugin folder (above) to the Broadstreet vendor folder.
 * Don't add a trailing slash.
 * 
 * Default: vendor/broadstreet
 */
define('BROADSTREET_VENDOR_PATH', 'Broadstreet/Vendor/broadstreet-partner');

/**
 * When the Broadstreet modal closes, what is the selector of the field
 * that needs to be updated with the ad code? 
 */
define('BROADSTREET_AD_TAG_SELECTOR', '#adcode');

/**
 * Display debugging information 
 */
define('BROADSTREET_DEBUG', false);

/**
 * *****************************************************************************
 * Database Area: Only use this if you plan to use database-back storage. If
 *  you're using Wordpress, you don't need this.
 * - Useful for load-balanced applications
 * - Persisting data between browser sessions
 * *****************************************************************************
 */

/* Use the database? */
if(!defined('BROADSTREET_USE_DATABASE')) define('BROADSTREET_USE_DATABASE', false);

/* Database config */
if(!defined('BROADSTREET_DB_HOST')) define('BROADSTREET_DB_HOST', '');
if(!defined('BROADSTREET_DB_NAME')) define('BROADSTREET_DB_NAME', '');
if(!defined('BROADSTREET_DB_USER')) define('BROADSTREET_DB_USER', '');
if(!defined('BROADSTREET_DB_PASS')) define('BROADSTREET_DB_PASS', '');
if(!defined('BROADSTREET_DB_TABLE')) define('BROADSTREET_DB_TABLE', 'bs_options');