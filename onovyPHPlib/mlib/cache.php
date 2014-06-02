<?php
/**
 * Modul pro manipulaci s diskovou cache.
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_CACHE',1);

/**
 * Overeni, jestli neni nutne provest vycisteni cache
 */
function cache_checkcache() {
    global $lib_config;

    $file = WEB_DIR . '/cache/last_clean';

    if (!file_exists($file) || time() - filemtime($file)>$lib_config['mlib_cache_cache_time']) {
	$f=fopen($file,'w');
	fwrite($f,time());
	fclose($f);

	clearstatcache();
	
	cache_cleancache();
    }
}

/**
 * Precteni dat z disk cache
 *
 * @param $context - context
 * @param $file - nazev souboru
 * @return obsah cache nebo false, pokud soubor neexistuje
 */
function cache_getcache($context,$file) {
    global $local_config;
    
    if (!$local_config['use_cache']) {
	return false;
    }

    cache_checkcache();
        
    $s1   = substr($file,0,1);
    $s12  = substr($file,0,2);
    $s123 = substr($file,0,3);
    $fname = WEB_DIR . '/cache/' . $context . '/' . $s1 . '/' . $s12 . '/' . $s123 . '/' . $file;

    if (file_exists($fname)) {
	return implode('',file($fname));
    } else {
	return false;
    }
}

/**
 * Zapsaní dat do disk cache
 *
 * @param $context - context
 * @param $file - nazev souboru
 * @param $data - data pro ulození
 */
function cache_putcache($context,$file,$data) {
    $s1   = substr($file,0,1);
    $s12  = substr($file,0,2);
    $s123 = substr($file,0,3);
    $fdir = WEB_DIR . '/cache/' . $context . '/' . $s1 . '/' . $s12 . '/' . $s123;
    $fname = $fdir . '/' . $file;
    
    if (!file_exists($fdir)) {
	cache_RecursiveMkdir($fdir);
    }
    
    $f=fopen($fname,'w');
    fwrite($f,$data);
    fclose($f);
}

/**
 * Vycistení cache (maze pouze nepouzivane soubory)
 */
function cache_cleancache() {
    global $cache_time;

    $fdir = WEB_DIR . '/cache/';

    clearstatcache();

    cache_recursecleancache($fdir);
}

/**
 * Rekurzivni projiti adresaru a smazaní nepouzivanych souboru
 *
 * @internal
 * @param $file - adresar, ktery projit
 */
function  cache_recursecleancache($file) {
    global $lib_config;
    
    if (is_dir($file)) {
	$dir = opendir($file);
	while (($subfile = readdir($dir)) !== false) {
	    if ($subfile != '.' && $subfile != '..' && $subfile != 'last_clean' && $subfile != '.htaccess') {
		cache_recursecleancache($file . '/' . $subfile);
	    }
	}
    } else {
	if (time() - fileatime($file) >= $lib_config['mlib_cache_cache_time']) {
	    unlink($file);
	}
    }
}

/**
 * Vymazani cele cache
 */
function cache_purgecache() {
    cache_purgecache_(WEB_DIR.'/cache',0);
}

/**
 * Rekurzivni projiti adresaru a smazaní vsech souboru
 *
 * @internal
 * @param $file - adresar, ktery projit
 * @param $l - level - uroven jak je rekurze hluboko
 */
function  cache_purgecache_($file,$l) {
    if (is_dir($file)) {
	$dir = opendir($file);
	while (($subfile = readdir($dir)) !== false) {
	    if ($subfile != '.' && $subfile != '..' && $subfile != '.htaccess') {
		cache_purgecache_($file . '/' . $subfile,$l+1);
	    }
	}
	if ($l!=0) {
	    rmdir($file);
	}
    } else {
	unlink($file);
    }
}

/**
 * Rekurzivni vytvoreni adresaru
 *
 * @internal
 * @param $path - adresáø
 */
function cache_RecursiveMkdir($path) {
    if (!file_exists($path)) {
           cache_RecursiveMkdir(dirname($path));
           mkdir($path, 0777);
    }
}

?>