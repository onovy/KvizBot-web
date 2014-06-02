<?php
/**
 * Modul s funkcemi s инsli
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

function priceformat($s,$type='round') { 
    if ($type=='round') { 
        $s=round($s,2); 
    } elseif ($type=='ceil') { 
        $s=ceil($s*100)/100; 
    } 
     
    $ar=explode(".",$s); 
    if (strlen($ar[1])==0) { $ar[1].='0'; } 
    if (strlen($ar[1])==1) { $ar[1].='0'; } 
     
    $out=po3cislech($ar[0],'&nbsp;').',&nbsp;'.$ar[1]; 
     
    return $out; 
} 


?>