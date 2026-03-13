<?php
$w=input_array('w',array('','edit'));

$smarty->assign('texty_edit_perm',$auth->perm_w ?? null);

$smarty->assign('menu','otazky');
$smarty->assign('title','Licence otázek');

if ($w=='edit' && ($auth->perm_w ?? null)) {
    edit_text(4);
} else {
    show_text(4);
}
