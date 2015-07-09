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
 * Used for password resets and verification e-maisls because $_SERVER['SERVER_ADDR'] returns the IP
 * Don't forget to include 'http(s)://'
 */
$config['site_address'] = 'http://localhost';

/**
 * The e-mail address verification e-mails are sent from
 */
$config['verify_email_sender'] = 'verify@asynctive.com';

/**
 * Password reset expire time limit
 * In seconds
 */
$config['pw_reset_expire_time'] = 60*60;
