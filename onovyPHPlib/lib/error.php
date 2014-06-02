<?php
function show_error($error) {
    global $smarty;
    show_error_noe($error);

    $smarty->display('main.tpl');
    exit;
}

function show_error_noe($error) {
    global $smarty;
    $smarty->assign('sekce','Chyba');
    $smarty->assign('main_onovyPHPlib',1);
    $smarty->assign('main','error');
    $smarty->assign('error',$error);
}

function error_notnumeric($var) {
    show_error('Promмnnб \''.$var.'\' musн bэt инslo!');
}

function error_notchar($var) {
    show_error('Promмnnб \''.$var.'\' musн bэt jeden znak!');
}

function error_notarray($var,$array) {
    $error='Vstupnн promмnnб "'. HE($var) . '" musн nabэvat jednu z hodnot: ';
    $first=1;
    foreach ($array as $name=>$val) {
	if ($first) $first=0; else $error.=', ';
	$error.=$val;
    }
    show_error($error);
}

function error_notperm() {
    show_error('Nemбte dostateиnб prбva!');
}

?>