<?php
/**
 * This is the Broadstreet partner configuration file.
 */

/** 
 * What is your partner name? It doesn't make sense to use someone
 *  else's partner name, unless you want to make them rich.
 */
if(!defined('BROADSTREET_PARTNER_NAME')) define('BROADSTREET_PARTNER_NAME', '');

/**
 * Options are one of:
 *  wordpress, website
 */
if(!defined('BROADSTREET_PARTNER_TYPE')) define('BROADSTREET_PARTNER_TYPE', '');

/**
 * This is the name of the folder that sites in wp-content/plugins for
 * the plugin which is be integrated into. We try to detect this automatically,
 * but use this as a fallback.
 */
if(!defined('BROADSTREET_PARTNER_PLUGIN')) define('BROADSTREET_PARTNER_PLUGIN', '');

/**
 * The path from the main plugin to the Broadstreet vendor folder.
 * Don't add a trailing slash.
 * 
 * Default: vendor/broadstreet
 */
if(!defined('BROADSTREET_VENDOR_PATH')) define('BROADSTREET_VENDOR_PATH', '');

/**
 * Should we show the user the ad code in the last step? If not, we'll try
 *  to place the ad code in the selector specified in the
 *  BROADSTREET_AD_TAG_SELECTOR setting
 */
if(!defined('BROADSTREET_SHOW_CODE')) define('BROADSTREET_SHOW_CODE', false);

/**
 * When the Broadstreet modal closes, what is the selector of the field
 * that needs to be updated with the ad code? 
 */
if(!defined('BROADSTREET_AD_TAG_SELECTOR')) define('BROADSTREET_AD_TAG_SELECTOR', '#tag');

/**
 * Display debugging information 
 */
if(!defined('BROADSTREET_DEBUG')) define('BROADSTREET_DEBUG', false);

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