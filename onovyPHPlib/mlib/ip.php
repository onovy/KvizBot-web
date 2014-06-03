<?php
/**
 * Modul pro praci s IP
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_IP',1);

/**
  * Prevede IP na trosku viditelnejsi format (napr. reverzni zaznam k ip)
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
