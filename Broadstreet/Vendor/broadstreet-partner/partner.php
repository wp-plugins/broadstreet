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
 * This is the name of the folder that sites in wp-content/plugins for
 * the plugin which is be integrated into. We try to detect this automatically,
 * but use this as a fallback.
 */
define('BROADSTRET_PARTNER_PLUGIN', 'broadstreet');

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
define('BROADSTREET_DEBUG', true);
