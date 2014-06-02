<?php
/**
 * Naètení základních knihoven, modulù a knihoven webu
 */

define('ONOVY_PHP_LIB',1);

function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$script_start_time=microtime_float();

// Nacteni konstant
require_once OLIB_DIR . '/lib/consts.php';

// Poslani hlavicky pred moznym vystupem chyb
if ($header)
    require_once OLIB_DIR . '/lib/header.php';

// Pokud verbose>=1 tak overit konfiguraci
if ($local_config['verbose']>=1) {
    print 'Verbosita je '.$local_config['verbose'].'<br />';

    foreach ($consts['lib_config_rules'] as $rule) {
	if (!isset($lib_config[$rule])) {
	    print WEB_DIR . '/configs/lib.php: '.$rule.' není nastaveno!<br />';
	}
    }
    
    foreach ($consts['local_config_rules'] as $rule) {
	if (!isset($local_config[$rule])) {
	    print WEB_DIR . '/configs/local.php: '.$rule.' není nastaveno!<br />';
	}
    }
}

// Nastaveni locale
setlocale(LC_ALL,$lib_config['locale']);

// Podpurne knihovny
require_once OLIB_DIR . '/lib/str_ireplace.php';
require_once OLIB_DIR . '/lib/strings.php';

// Zakladni knihovny
require_once OLIB_DIR . '/lib/sql.php';
require_once OLIB_DIR . '/lib/error.php';
require_once OLIB_DIR . '/lib/smarty.php';
require_once OLIB_DIR . '/lib/input.php';

$smarty->assign('WEB_DIR',$local_config['web_dir']);
$smarty->assign('WEB_WWW',$local_config['web_www']);

$smarty->assign('CHARSET',$lib_config['charset']);

// Moduly
foreach ($lib_config['modules'] as $lib) {
    if ($local_config['verbose']>=2) print 'Naèítám modul ' . OLIB_DIR . '/mlib/'.$lib.'.php<br />';
    require_once OLIB_DIR . '/mlib/'.$lib.'.php';
}

// Knihovny webu
foreach ($lib_config['web_libs'] as $lib) {
    if ($local_config['verbose']>=2) print 'Naèítám knihovnu webu: ' . WEB_DIR . '/libs/'.$lib.'.php<br />';
    require_once WEB_DIR . '/libs/'.$lib.'.php';
}

?>