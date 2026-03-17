<?php
/**
 * Initialization of variables, loading configuration
 */

// Load configuration
require_once dirname(__FILE__) . '/../configs/lib.php';
require_once dirname(__FILE__) . '/../configs/web.php';
require_once dirname(__FILE__) . '/../configs/local.php';

error_reporting($local_config['error_reporting']);

define('WEB_DIR' , $local_config['web_dir']);
define('OLIB_DIR', $local_config['web_dir'] . '/onovyPHPlib');
define('WEB_WWW' , $local_config['web_www']);

$header=true;
