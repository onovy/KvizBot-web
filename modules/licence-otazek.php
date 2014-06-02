<?
$w=input_array('w',array('','edit'));

$smarty->assign('texty_edit_perm',$auth->perm_t);

$smarty->assign('menu','otazky');
$smarty->assign('title','Licence otázek');

if ($w=='edit' && $auth->perm_t) {
    edit_text(4);
} else {
    show_text(4);
}
?>