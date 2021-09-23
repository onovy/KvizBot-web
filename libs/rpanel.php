<?php

$score_count=10;
$cache_time=240;
$max_nick_len=10;

$show_m=date('m')-1;
$show_y=date('Y');
$table_month='score_'.$show_y.'_'.$show_m;

$file_name=WEB_DIR . '/cache/rpanel.htm';

if (!file_exists($file_name) || time()-filemtime($file_name)>=$cache_time || !$local_config['use_cache']) {
    // TOP MONTH
    $q=db_query(
	'SELECT nicks.id AS id,nicks.nick AS nick,tm.body AS body FROM '.$table_month.' tm LEFT JOIN nicks ON nicks.id=tm.nick ORDER BY tm.body DESC LIMIT '.$score_count
    );
    $top_month=sql2smarty($q,array('id','nick','body'));
    foreach ($top_month as $k=>$l) {
        $top_month[$k]->rnick=$l->nick;
	if (strlen($l->nick)>$max_nick_len) {
	    $top_month[$k]->nick=substr($l->nick,0,$max_nick_len);
	}
	$top_month[$k]->body=po3cislech($l->body,'&nbsp;');
    }
    $smarty->assign('rpanel_top_month',$top_month);

    // TOP ALL
    $q=db_query(
	'SELECT id,nick,body FROM nicks ORDER BY body DESC LIMIT '.$score_count
    );
    $top_all=sql2smarty($q,array('id','nick','body'));
    foreach ($top_all as $k=>$l) {
        $top_all[$k]->rnick=$l->nick;
	if (strlen($l->nick)>$max_nick_len) {
	    $top_all[$k]->nick=substr($l->nick,0,$max_nick_len);
	}
	$top_all[$k]->body=po3cislech($l->body,'&nbsp;');
    }
    $smarty->assign('rpanel_top_all',$top_all);

    // Fetch template
    $out = $smarty->fetch('rpanel.tpl');

    $f=fopen($file_name,'w');
    fwrite($f,$out);
    fclose($f);
    clearstatcache();
} else {
    $out = file($file_name);
    $out = implode('',$out);
}

$smarty->assign('rpanel',$out);
