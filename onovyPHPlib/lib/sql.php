<?php
function db_connect() {
    global $local_config;
    global $db_link;
    
    if (isset($db_link)) { return 0; }
    if (!empty($local_config['sql_user']) && !empty($local_config['sql_pass']) && !empty($local_config['sql_host'])) {
	$db_link = mysqli_connect($local_config['sql_host'],$local_config['sql_user'],$local_config['sql_pass']) or show_error('Doslo k chybe pri pripojovani k databazi, omlouvame se');
    } else {
	return false;
    }
    $db_link->set_charset($local_config['sql_charset']);
    $db_link->select_db($local_config['sql_name']) or show_error('Doslo k chybe pri vybirani databaze, omlouvame se');
    return true;
}

function db_query($question) {
    global $db_link;
    
    db_connect();
    $r = $db_link->query($question) or show_error("Chyba SQL: " . $db_link->error);
    return $r;
}

function db_query_noe($question) {
    global $db_link;
    
    db_connect();
    $r=$db_link->query($question);
    return $r;
}
			  
function db_fetch_array($query) {
 return $query->fetch_array();
}

function db_fquery($q) {
    return db_fetch_array(db_query($q));
}

function db_fquery_noe($q) {
    $r=db_query_noe($q);
    if ($r === NULL) return false;
    return db_fetch_array($r);
}

function db_insert_id() {
    global $db_link;
    
    return $db_link->$insert_id;
}

function db_escape_string($s) {
    global $db_link;
    
    db_connect();
    return $db_link->real_escape_string($s);
}

function sql_time_format($s) {
    return 'DATE_FORMAT('.$s.',"%d. %m. %Y %H:%i") AS '.$s;
}

function sql_date_format($s) {
    return 'DATE_FORMAT('.$s.',"%d. %m. %Y") AS '.$s;
}

function db_num_rows($q) {
    return $q->num_rows;
}

function db_affected_rows() {
    global $db_link;
    
    return $db_link->affected_rows;
}

function db_table_exists($table_name) {
    return db_query_noe('DESCRIBE '.db_escape_string($table_name));
}
