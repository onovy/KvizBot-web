<?php
function input_num($var) {
 $a=array_merge($_GET,$_POST);
 if (!is_numeric($a[$var])) {
   error_notnumeric($var);
 }
 return $a[$var];
}

function input_num_0($var) {
 if (($_REQUEST[$var] ?? '') =='') return 0;
 if (!is_numeric($_REQUEST[$var])) {
   error_notnumeric($var);
 }
 return $_REQUEST[$var];
}

function input_num_1($var) {
 if (($_REQUEST[$var] ?? null) == '') return -1;
 if (!is_numeric($_REQUEST[$var])) {
   error_notnumeric($var);
 }
 return $_REQUEST[$var];
}

function input_string($var) {
 $a=array_merge($_GET,$_POST);
 if (isset($a[$var])) {
  return db_escape_string($a[$var]);
 } else {
  return null;
 }
}

function input_char($var) {
 $a=array_merge($_GET,$_POST);
 if (strlen($a[$var] ?? null) != 1) {
    error_notchar($var);
 }
 return db_escape_string($a[$var] ?? null);
}

function input_array($var,$array) {
    $ret = input_array_noe($var,$array);
    if ($ret === false) {
	error_notarray($var,$array);
    }
    return $ret;
}
    
function input_array_noe($var,$array) {
    $a=array_merge($_GET,$_POST);
    foreach ($array as $name=>$val) {
	if (($a[$var] ?? null) == $val) return $a[$var] ?? null;
    }
    return false;
}
    
function input_checkbox($var) {
 if ($_REQUEST[$var]=='on') return true;
 return false;
}

function HE($s) {
 return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'ISO8859-1');
}
