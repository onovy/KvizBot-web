<?php
/**
 * Module for working with IP addresses
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_IP',1);

/**
  * Convert IP to a more human-readable format (e.g. reverse DNS record)
  *
  * @param $ip
  * @return $text
  */
function printable_ip($ip) {
    if (empty($ip)) return;
    $reverz = gethostbyaddr($ip);
    if ($ip == $reverz) return $ip;
    return $reverz . ' ('. $ip.')';
}
