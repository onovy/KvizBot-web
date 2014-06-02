<?php
/**
 * Modul pro typografickou upravu textu
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_TYPO',1);

/**
 * Typograficka uprava textu
 *
 * @param $s - vstupni text
 * @param $cache - ulozit do cache? true/false
 * @return vystupni text
 */
function typo($s,$cache=true) {
    if ($cache && defined('MODULE_CACHE')) {
	$md5=md5($s);
	cache_getcache('typo',$md5);
    }

    // spojovani jednopismennych slov s dalsimy pomoci '&nbsp;'
    $s=preg_replace('/(?:(?<=^\w)|(?<=\s\w))\s+(?=\w)/','&nbsp;',$s);
    
    // spojovani spojek po carce s dalsim slovem pomoci '&nbsp;'
//    $s=preg_replace('/,\s+(\w\w\w\w)\s+(\w+)/',', \1&nbsp;\2',$s); -- neni psano v typografickych pravidlech

    // spojovani cisel pomoci '&nbsp;'
    $s=preg_replace('/(?<=\d)\s+(?=\d)/','&nbsp;',$s); 

    // spojovani datumu pomoci '&nbsp;'
    $s=preg_replace('/(\d{1,2})\. (\d{1,2})\. (\d{2,4})/','\1.&nbsp;\2.&nbsp;\3',$s);  // 1. 1. 2000
    $s=preg_replace('/(\d{1,2})\. (\w+) (\d{2,4})/','\1.&nbsp;\2&nbsp;\3',$s);         // 1. kvetna 2000
    $s=preg_replace('/(\d{1,2})\. (\d{1,2})\./','\1.&nbsp;\2.&nbsp;\3',$s);            // 1. 1.
    $s=preg_replace('/(\d{1,2})\. (\w+)/','\1.&nbsp;\2',$s);                           // 1. kvetna

    // x-y
    $s=preg_replace('/(\d+)-(\d+)/','\1&#8211;\2',$s);

    // uvozovky
    $s=preg_replace('/&quot;(.+?)&quot;/','&#8222;\1&#8220;',$s); // "text"
    $s=preg_replace('/\'(.+?)\'/','&#8218;\1&#8216;',$s); 	  // 'text'

    // rozmery (10x20 a 10x20x30)
    $s=preg_replace('/(\d+)x(\d+)x(\d+)/','\1&#215;\2&#215;\3',$s);// 10x20x30
    $s=preg_replace('/(\d+)x(\d+)/','\1&#215;\2',$s);              // 10x10

    // prevody symbolu
    $s=str_replace('&lt;-&gt;','&#8596',$s); // <->
    $s=str_replace('-&gt;','&#8594;',$s);    // ->
    $s=str_replace('&lt;-','&#8592',$s);     // <-
    $s=str_replace('--','&#8211;',$s);       // --
    $s=str_replace('...','&#8230;',$s);      // ...

    $s=str_replace('(TM)','&#153;',$s);      // (TM)
    $s=str_replace('(R)','&#174;',$s);       // (R)
    $s=str_replace('(C)','&#169;',$s);       // (C)

    if ($cache && defined('MODULE_CACHE')) {
	cache_putcache('typo',$md5,$s);
    }
    return $s;
}
?>