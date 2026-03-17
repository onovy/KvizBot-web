<?php

$lib_config['charset']='utf-8';

$lib_config['locale']='cs_CZ.UTF-8';

// Web libraries (included from libs/$.php)
$lib_config['web_libs']=array(
    'auth','rpanel'
);

// Modules:
//  typo - typographic text processing
//  gentime - page generation time measurement
//  c_year - year for copyright in the footer
//  texty - texts from DB
//  ot2html - newer version of text converter
//  num - functions for working with numbers
//  cache - functions for working with disk cache
//  ip - functions for working with IP addresses
$lib_config['modules']=array(
    'gentime','c_year','texty','ot2html','typo','num','cache','ip'
);

// Module configuration

// Texty
$lib_config['mlib_texty_table_name']='texty';
$lib_config['mlib_texty_count']=4;
// Cache
$lib_config['mlib_cache_cache_time']=60 * 60 * 24 * 7; // 7 dni
// C_year
$lib_config['mlib_c_year_from_year']=2005;
