<?

$fa=db_fquery(sprintf(
    'SELECT COUNT(*) FROM otazky WHERE last IS NULL'
));
$smarty->assign('fronta', $fa[0]);

$fa=db_fquery(sprintf(
    'SELECT COUNT(*) FROM otazky WHERE last IS NOT NULL'
));
$smarty->assign('zobrazeno', $fa[0]);

$fa=db_fquery(sprintf(
    'SELECT MIN(last) FROM otazky'
));
$smarty->assign('min', $fa[0]);

$fa=db_fquery(sprintf(
    'SELECT MAX(last) FROM otazky'
));
$smarty->assign('max', $fa[0]);

$smarty->assign('main', 'stats');
$smarty->assign('menu','otazky');
$smarty->assign('title','Stats');
