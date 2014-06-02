<?
$w=input_array('w',array('','edit'));

$smarty->assign('texty_edit_perm',$auth->perm_t);

$smarty->assign('menu','pravidla');
$smarty->assign('title','Pravidla');

if ($w=='edit' && $auth->perm_t) {
    edit_text(2);
} else {
    show_text(2);
}
?>