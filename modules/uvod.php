<?php
$w=input_array('w',array('','edit'));

$smarty->assign('texty_edit_perm',$auth->perm_w);

$smarty->assign('menu','uvod');
$smarty->assign('title','Úvod');

if ($w=='edit' && $auth->perm_w) {
    edit_text(1);
} else {
    show_text(1);
}
