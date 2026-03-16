<?php
function str_findFirstNotOf($s,$ch) {
    for ($a = 0 ; $a<strlen($s) ; $a++) {
	if ($s[$a] != $ch) return $a;
    }
    return -1;
}
