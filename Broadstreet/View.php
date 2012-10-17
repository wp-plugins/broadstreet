<?php
/**
 * This file contains a class for loading the presentation layer/files
 *
 * @author Broadstreet Ads <labs@broadstreetads.com>
 */

/**
 * This class contains methods for loading Broadstreet views
 */
class Broadstreet_View
{
    /**
     * Load a view file. The file should be located in Broadstreet/Views.
     * @param string $file The filename of the view without the extenstion (assumed
     *  to be PHP)
     * @param array $data An associative array of data that be be extracted and
     *  available to the view
     */
    public static function load($file, $data = array())
    {
        $file = dirname(__FILE__) . '/Views/' . $file . '.php';

        if(!file_exists($file))
        {
            Broadstreet_Log::add('fatal', "View '$file' was not found");
            throw new Exception("View '$file' was not found");
        }

        # Extract the variables into the global scope so the views can use them
        extract($data);

        include($file);
    }
}