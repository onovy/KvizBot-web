<?php
/**
 * Module for displaying and editing texts stored in the DB
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_TEXTY',1);

/**
 * Display text loaded from DB by ID
 *
 * @param $id - text ID
 */
function show_text($id) {
    global $smarty;
    
    $smarty->assign('txt',get_text($id));

    $smarty->assign('main_onovyPHPlib',1);
    $smarty->assign('main','texty');
}

/**
 * Load text from DB and convert it via the ot2html module
 *
 * @param $id - text ID
 * @return loaded text
 */
function get_text($id) {
    return ot2html(get_text_o($id));
}

/**
 * Load raw text from DB
 *
 * @param $id - text ID
 * @return loaded text
 */
function get_text_o($id) {
    global $lib_config;

    $fa=db_fquery(sprintf(
	'SELECT txt FROM '.$lib_config['mlib_texty_table_name'].' WHERE id=%d',
	$id
    ));
    return $fa[0];
}

/**
 * Display edit form for a text entry, and optionally perform the update
 *
 * @param $id - ID textu
 */
function edit_text($id) {
    global $smarty;
    global $lib_config;
    global $local_config;

    $message='';

    $nahled=false;
        
    if ($_REQUEST['txt']!='') {
	$txt=input_string('txt');
	if ($_REQUEST['upravit']!='') {
	    csrf_verify();
	    $q=db_query(sprintf(
		'UPDATE '.$lib_config['mlib_texty_table_name'].' SET txt="%s" WHERE id=%d LIMIT 1',
		$txt,$id
	    ));
	    if ($q)
		$message='<font color="green">Upraveno</font>';
	    else
		$message='<font color="red">Chyba při upravování</font>';
	} else {
	    $smarty->assign('nahled',ot2html($_REQUEST['txt'],false));
	    $smarty->assign('txt',$_REQUEST['txt']);
	    $nahled=true;
	}
    }
    if (!$nahled) {
	smarty_message($message);
	$smarty->assign('txt',get_text_o($id));
    }
    $smarty->assign('main','texty_edit');
    $smarty->assign('main_onovyPHPlib',1);
}

// verify that the table exists
if ($local_config['verbose']>=1) {
    $fa=db_query_noe('DESCRIBE '.$lib_config['mlib_texty_table_name'])
	or print 'Tabulka pro modul TEXTY ('.$lib_config['mlib_texty_table_name'].') neexistuje<br />';
}
