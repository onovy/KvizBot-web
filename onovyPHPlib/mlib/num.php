<?php
/**
 * Module with numeric helper functions
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_NUM',1);

/**
 * Rozdeli cislo po 3 cislicich (10000 -> 10 000)
 *
 * @param $s - vstup
 * @param $splitter - znak, kterym rozdelit cislo
 * @return vystup
 */
function po3cislech($s,$splitter=' ') { 
    for ($a=strlen($s)-3; $a>=0 ; $a-=3) {
	$s=substr($s,0,$a) . $splitter . substr($s,$a);
    }

    return $s;
}

