<?php
require_once OLIB_DIR . '/extlib/Smarty/libs/Smarty.class.php';

use Smarty\Smarty;

$smarty = new Smarty;

$smarty->setTemplateDir(WEB_DIR . '/templates');
$smarty->setCompileDir(WEB_DIR . '/templates_c');
$smarty->setCacheDir(WEB_DIR . '/cache');
$smarty->setConfigDir(WEB_DIR . '/configs');

$smarty->setCompileCheck($local_config['compile_check']);

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

function smarty_message($msg, $color='message') {
    global $smarty;
    $smarty->assign('message', $msg);
    $smarty->assign('message_c', $color);
}
