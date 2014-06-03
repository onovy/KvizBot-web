<?php
function db_connect() {
    global $local_config;
    global $db_link;
    
    if (isset($db_link)) { return 0; }
    if (!empty($local_config['sql_user']) && !empty($local_config['sql_pass']) && !empty($local_config['sql_host'])) {
	$db_link = mysql_connect($local_config['sql_host'],$local_config['sql_user'],$local_config['sql_pass']) or show_error('Doslo k chybe pri pripojovani k databazi, omlouvame se');
    } else {
	return false;
    }
    mysql_select_db($local_config['sql_name'], $db_link) or show_error('Doslo k chybe pri vybirani databaze, omlouvame se');
    return true;
}

function db_query($question) {
    global $db_link;
    
    db_connect();
    $r=mysql_query($question, $db_link) or show_error("Chyba SQL: ".mysql_error());
    return $r;
}

function db_query_noe($question) {
    global $db_link;
    
    db_connect();
    $r=mysql_query($question, $db_link);
    return $r;
}
			  
function db_fetch_array($query) {
 return mysql_fetch_array($query);
}

function db_fquery($q) {
    return db_fetch_array(db_query($q));
}

function db_fquery_noe($q) {
    $r=db_query_noe($q);
    if ($r === false) return false;
    return db_fetch_array($r);
}

function db_insert_id() {
    global $db_link;
    
    return mysql_insert_id($db_link);
}

function db_escape_string($s) {
    global $db_link;
    
    if (db_connect()) {
	return mysql_real_escape_string($s, $db_link);
    } else {
	return mysql_escape_string($s);
    }
}

function sql_time_format($s) {
    return 'DATE_FORMAT('.$s.',"%d. %m. %Y %H:%i") AS '.$s;
}

function sql_date_format($s) {
    return 'DATE_FORMAT('.$s.',"%d. %m. %Y") AS '.$s;
}

function db_num_rows($q) {
    return mysql_num_rows($q);
}

function db_affected_rows() {
    global $db_link;
    
    return mysql_affected_rows($db_link);
}

function db_table_exists($table_name) {
    return db_query_noe('DESCRIBE '.db_escape_string($table_name));
}
