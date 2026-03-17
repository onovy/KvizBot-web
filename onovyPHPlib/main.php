<?php
/**
 * Load core libraries, modules, and web libraries
 */

define('ONOVY_PHP_LIB',1);

$script_start_time=microtime(true);

// Load constants
require_once OLIB_DIR . '/lib/consts.php';

// Send header before any possible error output
if ($header)
    require_once OLIB_DIR . '/lib/header.php';

// If verbose>=1, verify configuration
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

// Set locale
setlocale(LC_ALL,$lib_config['locale']);

// Support libraries
require_once OLIB_DIR . '/lib/strings.php';

// Core libraries
require_once OLIB_DIR . '/lib/sql.php';
require_once OLIB_DIR . '/lib/error.php';
require_once OLIB_DIR . '/lib/smarty.php';
require_once OLIB_DIR . '/lib/input.php';
require_once OLIB_DIR . '/lib/csrf.php';

$smarty->assign('WEB_DIR',$local_config['web_dir']);
$smarty->assign('WEB_WWW',$local_config['web_www']);

$smarty->assign('CHARSET',$lib_config['charset']);

// Modules
foreach ($lib_config['modules'] as $lib) {
    if ($local_config['verbose']>=2) print 'Načítám modul ' . OLIB_DIR . '/mlib/'.$lib.'.php<br />';
    require_once OLIB_DIR . '/mlib/'.$lib.'.php';
}

// Web libraries
foreach ($lib_config['web_libs'] as $lib) {
    if ($local_config['verbose']>=2) print 'Načítám knihovnu webu: ' . WEB_DIR . '/libs/'.$lib.'.php<br />';
    require_once WEB_DIR . '/libs/'.$lib.'.php';
}
