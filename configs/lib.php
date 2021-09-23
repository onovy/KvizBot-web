<?php

$lib_config['charset']='iso-8859-2';

$lib_config['locale']='CZ_cs.ISO-8859-2';

// Knihovny webu (include z libs/$.php)
$lib_config['web_libs']=array(
    'auth','rpanel'
);

// Moduly:
//  auth - Autorizace uzivatelu pres HTTP auth
//  i2html - konvertor textu
//  mime - mime prevodnik
//  typo - typograficka uprava textu
//  gentime - pocitani doby generace stranky
//  c_year - rok pro copyright v paticce
//  texty - texty z DB
//  ot2html - novejsi verze konvertoru textu
//  num - funkce pro praci s cisly
//  cache - funkce pro praci s diskovou cache
//  ip - funkce pro praci s IP adresou
$lib_config['modules']=array(
    'gentime','c_year','texty','ot2html','typo','num','cache','auth','ip'
);

// Konfigurace modulu

// Texty
$lib_config['mlib_texty_table_name']='texty';
$lib_config['mlib_texty_count']=4;
// Auth
$lib_config['mlib_auth_table_name']='auth_table_not_use';
// Cache
$lib_config['mlib_cache_cache_time']=60 * 60 * 24 * 7; // 7 dni
// C_year
$lib_config['mlib_c_year_from_year']=2005;
