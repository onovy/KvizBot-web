<?php
/**
 * Modul pro HTTP autorizaci uzivatele proti databazi.
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_AUTH',1);

/**
 * Autorizace uzivatele proti databazi
 * Vstupni data jsou cteny z HTTP autentifikace
 */
function auth_user() {
    global $auth;
    global $lib_config;
    global $local_config;

    if ($_REQUEST['page']=='logout') return false;

    // overeni existence tabulky    
    if ($local_config['verbose']>=1) {
	$chyba=false;
	$fa=db_query_noe('DESCRIBE '.$lib_config['mlib_auth_table_name']) or $chyba=true;
	
	if ($chyba) {
	    print('Tabulka pro modul AUTH ('.$lib_config['mlib_auth_table_name'].') neexistuje<br />');
	    $auth->id=0;
	    $auth->uname="";
	    return false;
	}
    }

    $user=db_escape_string($_SERVER['PHP_AUTH_USER']);
    $pass=$_SERVER['PHP_AUTH_PW'];
    $f=db_fquery_noe(sprintf(
	'SELECT id FROM '.$lib_config['mlib_auth_table_name'].' WHERE user="%s" AND pass="%s"',
	$user,md5($pass)
	));
    if (empty($f[0]) || $_COOKIE['logout']==1) {
	$auth->id=0;
	$auth->uname="";
	return false;
    } else {
	db_query(sprintf(
	    'UPDATE '.$lib_config['mlib_auth_table_name'].' SET last_action=now() WHERE id=%d',
	    $f[0]
	));
	$auth->id=$f[0];
	$auth->uname=$user;
	return true;
    }
}

function auth_show401() {
    global $smarty;

    header('WWW-Authenticate: Basic realm="Autorizace"');
    header('HTTP/1.0 401 Unauthorized');
    setcookie('logout',0);

    $smarty->assign('title','Autorizace selhala');
    $smarty->assign('main','no_access');
    $smarty->assign('main_onovyPHPlib',1);
    $smarty->display('main.tpl');
    exit;
}

auth_user();
$smarty->assign('auth',$auth);
