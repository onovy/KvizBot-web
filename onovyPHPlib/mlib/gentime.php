<?php
/**
 * Module for measuring page generation time.
 * Before output is displayed, <!--$gentime//--> is replaced with the
 * generation time value.
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_GENTIME',1);

/**
 * Replace <!--$gentime//--> with the actual page generation time before
 * sending output to the browser
 *
 * @internal
 * @param $tpl_source - input data
 * @param &$smarty - reference to the Smarty class
 * @return output data
 */
function smarty_ondisplay($tpl_source, $template) {
    global $script_start_time;
    $gentime=round(microtime(true)-$script_start_time,4);
    return preg_replace('/<!--\$gentime\/\/-->/U',$gentime,$tpl_source);
}

// Register output filter in the Smarty class
$smarty->registerFilter('output', 'smarty_ondisplay');
