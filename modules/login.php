<?php

if(!isset($_SERVER['PHP_AUTH_USER'])) {
    auth_show401();
} else {
    if ($auth->id==0) auth_show401();
    $smarty->assign('menu','login');
    $smarty->assign('title','Pøihlá¹ení');
    $smarty->assign('main','login');
}
