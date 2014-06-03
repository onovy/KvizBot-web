<?php
require_once OLIB_DIR . '/extlib/Smarty/Smarty.class.php';

$smarty = new Smarty;

$smarty->compile_check = $local_config['compile_check'];

function sql2smarty($s,$array) {
 $a=0;
 $out=array();
 while ($line=db_fetch_array($s)) {
  foreach ($array as $name=>$val) {
   $out[$a]->$val=$line[$val];
  }
  $a++;
 }
 return $out;
}

function var2smarty($array) {
    global $smarty;
    foreach ($array as $name=>$val) {
	$ttt = 'global $'.$val.';'.'$a=$'.$val.';';
	eval($ttt);
	$smarty->assign($val,$a);
    }
}

function fa2smarty($line,$array) {
 foreach ($array as $name=>$val) {
  $out->$val=$line[$val];
 }
 return $out;
}

$smarty->assign('main_onovyPHPlib',0);
