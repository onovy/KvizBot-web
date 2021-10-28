<?php

$score_count=50;
$start_y=2005;
$start_m=5;

$smarty->assign('menu','skore');
$smarty->assign('title','Skóre');

$w=input_array('w',array('','search','info','move'));

if ($w=='search') {
    $nick=input_string('nick');
    $q=db_query(sprintf(
	'SELECT id,nick FROM nicks WHERE nick LIKE "%%%s%%" LIMIT 10',
	$nick
    ));
    $smarty->assign('result',sql2smarty($q,array('id','nick')));

    $smarty->assign('main','skore_search');
    return;
}

if ($w=='info') {
    $id=input_num_1('user');
    if ($id == -1) {
	$nick=input_string('nick');
	$fa=db_fquery(sprintf(
	    'SELECT id FROM nicks WHERE nick="%s"',
	    $nick
	));
	$id=$fa[0];
	if (empty($id)) {
	    show_error('Nick nenalezen: ' . $nick);
	}
    }

    list($pozice,$body,$nick,$added)=infouser($id,'all');
    
    $smarty->assign('nick',$nick);
    $smarty->assign('id',$id);
    $smarty->assign('pozice',$pozice);
    $pozice_all = $pozice;
    $smarty->assign('body',po3cislech($body,'&nbsp;'));
    if (empty($added)) $added='Døíve ne¾ 26. 9. 2005';
    $smarty->assign('added',$added);

    $history=array();
    $max = 0;
    $pos=0;

    // Kviz 1
    list($pozice,$body,$nick,$added)=infouser($id,'month','score_kviz1');
    if ($body!=0) {
	$history[$pos] = new \stdClass();
	$history[$pos]->name='Kvíz 1.0';
	$history[$pos]->body_orig=$body;
	$history[$pos]->body=po3cislech($body,'&nbsp;');
	$history[$pos]->pozice=$pozice;
	if ($body > $max)
	    $max = $body;
	$pos++;
    }

    $now_m=date('m')-1;
    $now_y=date('Y');
    $m=$start_m;
    $y=$start_y;
    while (1) {
	list($pozice,$body,$nick,$added)=infouser($id,'month','score_'.$y.'_'.$m);
	if ($body!=0) {
	    $history[$pos] = new \stdClass();
    	    $history[$pos]->name=$consts['months_name'][$m+1].' '.$y;
	    $history[$pos]->body_orig=$body;
	    $history[$pos]->body=po3cislech($body,'&nbsp;');
	    $history[$pos]->pozice=$pozice;
	    $pos++;
	    if ($body > $max)
		$max = $body;
	}
	
	if ($now_m==$m && $now_y==$y) break;

	$m++;
	if ($m==12) {
	    $y++;
	    $m=0;
	}
    }
    
    foreach ($history as $k=>$v) {
	$history[$k]->width = ($v->body_orig/$max) * 100;
    }

    $smarty->assign('history',$history);

    $offset = $pozice_all-4;
    if ($offset<0) $offset=0;
    $q=db_query(sprintf(
	'SELECT id,nick,body FROM nicks ORDER BY body DESC, last DESC, id DESC LIMIT 7 OFFSET %d',
	$offset
    ));
    $scene=sql2smarty($q,array('id','nick','body'));
    $pos = $offset;
    foreach ($scene as $k=>$l) {
	$pos++;
	$scene[$k]->pos = $pos;
	$scene[$k]->body=po3cislech($l->body,'&nbsp;');
    }
    $smarty->assign('scene',$scene);

    $smarty->assign('main','skore_info');
    return;
}

if ($w=='move' && $auth->perm_a) {
    $id = input_num('id');
    $nick_to = input_string('nick');
    $fa = db_fquery(sprintf(
	'SELECT nick FROM nicks WHERE id = %d',
	$id
    ));
    $nick = $fa['nick'];
    $fa = db_fquery(sprintf(
	'SELECT id FROM nicks WHERE nick = "%s"',
	$nick_to
    ));
    $done = false;
    if ($fa['id']) {
	$smarty->assign('error', 'Cílový nick ji¾ existuje, zmìnu není mo¾né provést!');	
    } else {
	if (!empty($_POST['confirm'])) {
	    $q = db_query(sprintf(
		'UPDATE nicks SET nick = "%s" WHERE id = %d',
		$nick_to, $id
	    ));
	    
	    $done = true;
	}
    }
    
    if (!$done) {
	$smarty->assign('main','skore_move');
	$smarty->assign('nick',$nick);
	$smarty->assign('nick_to',$nick_to);
	$smarty->assign('id',$id);
        return;
    }
}

$show_m=input_num_1('month');
$show_y=input_num_1('year');
if ($show_m==-1 || $show_y==-1) {
    $show_m=date('m')-1;
    $show_y=date('Y');
}
$table_month='score_'.$show_y.'_'.$show_m;
if (!db_table_exists($table_month)) {
    show_error('Skóre pro tento mìsíc neexistuje');
}

// TOP ALL
$q=db_query(
    'SELECT id,nick,body FROM nicks ORDER BY body DESC, last DESC, id DESC LIMIT '.$score_count
);
$top_all=sql2smarty($q,array('id','nick','body'));
foreach ($top_all as $k=>$l) {
    $top_all[$k]->body=po3cislech($l->body,'&nbsp;');
}
$smarty->assign('top_all',$top_all);

// TOP MONTH
$q=db_query(
    'SELECT nicks.id AS id,nicks.nick AS nick,tm.body AS body FROM '.$table_month.' tm LEFT JOIN nicks ON nicks.id=tm.nick ORDER BY tm.body DESC LIMIT '.$score_count
);
$top_month=sql2smarty($q,array('id','nick','body'));
foreach ($top_month as $k=>$l) {
    $top_month[$k]->body=po3cislech($l->body,'&nbsp;');
}
$smarty->assign('top_month',$top_month);

$smarty->assign('top_month_name',$consts['months_name'][$show_m+1].' '.$show_y);

$show_y_p = $show_y;
$show_y_n = $show_y;
$show_m_p = $show_m-1;
$show_m_n = $show_m+1;
if ($show_m_p == -1) {
    $show_m_p=11;
    $show_y_p-=1;
}
if ($show_m_n == 12) {
    $show_m_n=0;
    $show_y_n+=1;
}
$table_month_p='score_'.$show_y_p.'_'.$show_m_p;
$table_month_n='score_'.$show_y_n.'_'.$show_m_n;

$ahref=db_table_exists($table_month_p);
$smarty->assign('top_month_name_p',
    ($ahref?'<a href="?year='.$show_y_p.'&amp;month='.$show_m_p.'">':'').
	$consts['months_name'][$show_m_p+1].' '.$show_y_p.
    ($ahref?'</a>':'')
);

$ahref=db_table_exists($table_month_n);
$smarty->assign('top_month_name_n',
    ($ahref?'<a href="?year='.$show_y_n.'&amp;month='.$show_m_n.'">':'').
	$consts['months_name'][$show_m_n+1].' '.$show_y_n.
    ($ahref?'</a>':'')
);

$smarty->assign('main','skore');

function infouser($id,$typ,$table='') {
    if ($typ=='month') {
	$fa=db_fquery(sprintf(
	    'SELECT body FROM '.$table.' WHERE nick=%d',
	    $id
        ));
	$bodu=$fa[0];
	$pozice=db_fquery(sprintf(
	    'SELECT COUNT(*)+1 AS pozice FROM '.$table.' WHERE body>%d',
	    $bodu
	));
	$pozice=$pozice[0];
	$nick='?';
    } else {
	$fa=db_fquery(sprintf(
	    'SELECT body,nick,DATE_FORMAT(added,"%%d. %%m. %%Y %%H:%%i") AS added, last FROM nicks WHERE id=%d',
	    $id
        ));
	$bodu=$fa['body'];
	$nick=$fa['nick'];
	$added=$fa['added'];
	$last=$fa['last'];

	$pozice=db_fquery(sprintf(
	    'SELECT COUNT(*)+1 AS pozice FROM nicks WHERE body>%d OR (body=%d AND last>"%s") OR (body=%d AND last="%s" AND id>%d)',
	    $bodu, $bodu, $last, $bodu, $last, $id
	));
	$pozice=$pozice[0];
    }
    
    return array($pozice,$bodu,$nick,$added);
}
