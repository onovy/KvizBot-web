<?

$q=db_query(
    'SELECT nick FROM nicks ORDER BY body DESC, last DESC, id DESC LIMIT 3'
);
$pos = 1;
$med=array();
while ($fa=db_fetch_array($q)) {
    $med[$fa['nick']]=$pos;
    $pos++;
}

$medm=array();
$show_m=date('m')-1;
$show_y=date('Y');
$table_month='score_'.$show_y.'_'.$show_m;
if (db_table_exists($table_month)) {
    $q=db_query(
	'SELECT nicks.id AS id,nicks.nick AS nick,tm.body AS body FROM '.$table_month.' tm LEFT JOIN nicks ON nicks.id=tm.nick ORDER BY tm.body DESC LIMIT '.$score_count
    );
    $pos = 1;
    while ($fa=db_fetch_array($q)) {
	$medm[$fa['nick']]=$pos;
	$pos++;
    }
}

$q=db_query('SELECT nicks.id AS id,online.nick FROM online LEFT JOIN nicks ON LOWER(nicks.nick)=LOWER(online.nick) ORDER BY online.nick');
$online=sql2smarty($q,array('id','nick'));
foreach ($online as $k=>$v) {
    if (array_key_exists($v->nick, $med)) {
	$online[$k]->med=$med[$v->nick];
    }
    if (array_key_exists($v->nick, $medm)) {
	$online[$k]->medm=$medm[$v->nick];
    }
}

$smarty->assign('online',$online);

$smarty->assign('count',count($online));

$smarty->assign('menu','online');
$smarty->assign('title','Online');
$smarty->assign('main','online');
?>