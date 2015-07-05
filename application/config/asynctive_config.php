<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// **** Put all Asynctive Web specific configuration settings in this file ****

/**
 * Path to the controllers directory
 */
$config['controller_path'] = APPPATH . 'controllers/';

/**
 * Whether the site is offline and nobody but admins can visit it, good for maintenance
 * Only admins logged in will be able to view it
 */
$config['offline_mode'] = FALSE;

/**
 * The site domain name address
 * Used for password resets and redirects because $_SERVER['SERVER_ADDR'] returns the IP
 * Don't forget to include 'http(s)://' unless you're using localhost
 */
$config['site_address'] = 'localhost';