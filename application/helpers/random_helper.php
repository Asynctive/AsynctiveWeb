<?php

/**
 * Function for generating a random string of hexadecimial characters
 * @param int
 * @return string
 */
function generateRandomHexString($length)
{
	assert($length > 0);
	
	// One byte = two digit hex number
	$byte_length = ceil($length / 2);
	$str_length = ($length % 2 == 0) ? $byte_length : $length;			// Handle odd numbers
	return substr(bin2hex(openssl_random_pseudo_bytes($length)), 0, $length);
}
