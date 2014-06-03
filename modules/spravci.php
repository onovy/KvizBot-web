<?
$q=db_query('SELECT nicks.nick FROM perm LEFT JOIN nicks ON perm.nick=nicks.id WHERE perm="s" ORDER BY nick');
$smarty->assign('spravci',sql2smarty($q,array('nick')));

$smarty->assign('menu','spravci');
$smarty->assign('title','Správci');
$smarty->assign('main','spravci');
