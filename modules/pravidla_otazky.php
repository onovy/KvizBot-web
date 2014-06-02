<?
$w=input_array('w',array('','edit'));

$smarty->assign('texty_edit_perm',$auth->perm_t);

$smarty->assign('menu','otazky');
$smarty->assign('title','Pravidla pro psaní otázek');

if ($w=='edit' && $auth->perm_t) {
    edit_text(3);
} else {
    show_text(3);
}
?>