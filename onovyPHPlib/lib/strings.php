<?php
function str_startsWith($s,$need) {
    return (substr($s,0,strlen($need)) == $need);
}

function str_endsWith($s,$need) {
    return (substr($s,strlen($s)-strlen($need)) == $need);
}
    
function str_findFirstNotOf($s,$ch) {
    for ($a = 0 ; $a<strlen($s) ; $a++) {
	if ($s[$a] != $ch) return $a;
    }
    return -1;
}
?>