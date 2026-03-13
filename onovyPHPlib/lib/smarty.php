<?php
require_once OLIB_DIR . '/extlib/Smarty/Smarty.class.php';

$smarty = new Smarty;

$smarty->compile_check = $local_config['compile_check'];

function sql2smarty($s,$array) {
 $a=0;
 $out=array();
 while ($line=db_fetch_array($s)) {
  foreach ($array as $name=>$val) {
   if (!isset($out[$a])) {
    $out[$a] = new \stdClass();
   }
   $out[$a]->$val=$line[$val];
  }
  $a++;
 }
 return $out;
}

function fa2smarty($line,$array) {
 $out = new \stdClass();
 foreach ($array as $name=>$val) {
  $out->$val=$line[$val];
 }
 return $out;
}

$smarty->assign('main_onovyPHPlib',0);
