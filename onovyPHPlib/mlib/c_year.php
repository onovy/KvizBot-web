<?php
/**
 * Modul pro zobrazovani roku pro (C) napr. v paticce stranky.
 * Pocatecni rok se nastavuje ve web.php promenna mlib_c_year_from_year.
 * Vystup se ulozí do SMARTY promenne c_rok.
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
