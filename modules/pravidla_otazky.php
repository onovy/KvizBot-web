<?php
$w=input_array('w',array('','edit'));

$smarty->assign('texty_edit_perm',$auth->perm_w);

$smarty->assign('menu','otazky');
$smarty->assign('title','Pravidla pro psan� ot�zek');

if ($w=='edit' && $auth->perm_w) {
    edit_text(3);
} else {
    show_text(3);
}
