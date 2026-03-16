<?php
/**
 * Module for displaying the copyright year (e.g. in the page footer).
 * The starting year is set in web.php via the mlib_c_year_from_year variable.
 * Output is stored in Smarty variable c_rok.
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_C_YEAR',1);

$from=$lib_config['mlib_c_year_from_year'];
$rok=date("Y");
if ($rok!=$from) {
    $smarty->assign('c_rok',$from.'&#8211;'.$rok);
} else {
    $smarty->assign('c_rok',$from);
}
