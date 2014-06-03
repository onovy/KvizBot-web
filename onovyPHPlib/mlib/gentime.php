<?php
/**
 * Modul pro mereni casu generovani stranky.
 * Pred zobrazenim vystupnich dat se provede zamena <!--$gentim//--> za hodnotu
 * casu
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_GENTIME',1);

/**
 * Konverze <!--$gentime//--> pred odeslanim textu prohlizeci na konkretni cas
 * generace stranky
 *
 * @internal
 * @param $tpl_source - vstupni data
 * @param &$smarty - reference na Smarty tridu
 * @return vystupni data
 */
function smarty_ondisplay($tpl_source, &$smarty) {
    global $script_start_time;
    $gentime=round(microtime_float()-$script_start_time,4);
    return preg_replace('/<!--\$gentime\/\/-->/U',$gentime,$tpl_source);
}

// Zaregistrovani vystupniho filteru v tride Smarty		   
$smarty->register_outputfilter("smarty_ondisplay");
