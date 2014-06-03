<?php
/**
 * Inicializace promìnných, naètení konfigurace
 */

// Nacteni konfigurace
require_once dirname(__FILE__) . '/../configs/lib.php';
require_once dirname(__FILE__) . '/../configs/web.php';
require_once dirname(__FILE__) . '/../configs/local.php';

error_reporting($local_config['error_reporting']);

define('WEB_DIR' , $local_config['web_dir']);
define('OLIB_DIR', $local_config['web_dir'] . '/onovyPHPlib');
define('WEB_WWW' , $local_config['web_www']);

if ($_REQUEST['cache']=='on') {
    $local_config['compile_check'] = false;
    $local_config['use_cache'] = true;
}
if ($_REQUEST['cache']=='off') {
    $local_config['compile_check'] = true;
    $local_config['use_cache'] = false;
}

$header=true;
