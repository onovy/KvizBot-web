<?php

if (!$auth->id) {
    error_notperm();
}

$stavy['open']='Otevøená';
$stavy['close']='Opravená';
$stavy['unconfirmed']='Zamítnutá';

$smarty->assign('menu','chyby');
$smarty->assign('title','Chyby v otázkách');

$w=input_array('w',array('','add','list','info','set_stav'));

    if ($w=='list') {
	$filter=input_array('filter',array('','open','close','unconfirmed'));
	$smarty->assign('filter',$filter);
	$owner=input_array('owner', array('', 'me'));
	$smarty->assign('owner',$owner);
	$desc=input_array('desc',array('','1'));
	$smarty->assign('desc',$desc);
	$order=input_array('order',array('','pridano','cislo','nick'));
	if (empty($order)) {
	    $order='pridano';
	}
	$smarty->assign('order',$order);
	if ($order == 'pridano') $order = 'otazky_chyby.pridano';

	$where='';
	if (!empty($filter)) {
	    $where=sprintf(' WHERE stav="%s"',$filter);
	}
	if ($desc=='1') {
	    $desc=' DESC';
	}
	if ($owner == 'me') {
	    if (!empty($where)) {
		$where .= ' AND ';
	    } else {
		$where .= ' WHERE ';
	    }
	    $where .= sprintf('otazky_chyby.nick=%d', $auth->id);
	}
	
	$q=db_query(sprintf(
	    'SELECT otazky_chyby.id,cislo,stav,DATE_FORMAT(pridano,"%%d. %%m. %%Y %%H:%%i") AS pridano,nick_old,otazky_chyby.nick AS nick_id,nicks.nick FROM otazky_chyby LEFT JOIN nicks ON (nicks.id = otazky_chyby.nick)'.$where.' ORDER BY '.$order.$desc
	));
        $smarty->assign('chyby',sql2smarty($q,array('id','cislo','stav','pridano','nick_old', 'nick_id', 'nick')));

	$smarty->assign('main','chyby_list');
        return;
    }

if ($auth->perm_c) {
    if ($w=='set_stav') {
	$id=input_num('chyba');
	$stav=input_array('stav',array('open','close','unconfirmed'));
	$comment=input_string('comment');
	$ok=true;
	
	if (empty($comment) && $stav == 'unconfirmed') {
	    $smarty->assign('message','Musíte zadat komentáø pro zamítnutí chyby');
	    $smarty->assign('message_c','error');
	    $ok = false;
	}
	if ($stav != 'open' && $ok) {
	    db_query(sprintf(
		'UPDATE otazky_chyby SET uzavreno=now() WHERE id=%d',
	    	$id
	    ));
	}
	
	if ($ok) {
	    db_query(sprintf(
		'UPDATE otazky_chyby SET stav="%s", comment="%s" WHERE id=%d',
		$stav,$comment,$id
	    ));
	}
	
	$w='info';
    }
}

    if ($w=='info') {
	$id=input_num('chyba');
	$smarty->assign('chyba_id',$id);
	
	$fa=db_fquery(sprintf(
	    'SELECT otazky_chyby.id,cislo,link,text,stav,
	     DATE_FORMAT(pridano,"%%d. %%m. %%Y %%H:%%i") AS pridano,
	     DATE_FORMAT(uzavreno,"%%d. %%m. %%Y %%H:%%i") AS uzavreno,
	     nick_old,otazky_chyby.nick AS nick_id, nicks.nick, ip,
	     otazky.otazka, otazky.odpoved, comment
	      FROM otazky_chyby
	      LEFT JOIN nicks ON (nicks.id = otazky_chyby.nick) 
	      LEFT JOIN otazky ON (otazky.id = otazky_chyby.cislo)
	      WHERE otazky_chyby.id=%d',
	    $id
	));
	if (!str_startsWith($fa['link'],'http://')) {
	    $fa['link']='http://' . $fa['link'];
	}
	$fa['o_stav']=$fa['stav'];
	$fa['stav']=$stavy[$fa['stav']];
	$fa['ip']=printable_ip($fa['ip']);
	
	$info = fa2smarty($fa,array('id','cislo','link','text','o_stav','stav','pridano','uzavreno','nick_old','nick_id','nick','ip', 'otazka', 'odpoved', 'comment'));
	$info->text = NL2BR(HE($info->text));
	$smarty->assign('info', $info);

	// Nacteni seznamu souvisejicich chyb (stejne ID otazky)
	$refer=db_query(sprintf(
	    'SELECT otazky_chyby.id,stav,DATE_FORMAT(pridano,"%%d. %%m. %%Y %%H:%%i") AS pridano,DATE_FORMAT(uzavreno,"%%d. %%m. %%Y %%H:%%i") AS uzavreno,nick_old,otazky_chyby.nick AS nick_id, nicks.nick, ip FROM otazky_chyby LEFT JOIN nicks ON (nicks.id = otazky_chyby.nick) WHERE cislo=%d AND otazky_chyby.id!=%d ORDER BY otazky_chyby.pridano',
	    $fa['cislo'], $id
	));
	$refer = sql2smarty($refer,array('id','stav','pridano','uzavreno','nick_old','nick_id','nick','ip'));
        foreach ($refer as $c=>$l) {
	    $refer[$c]->stav = $stavy[$l->stav];
	    $refer[$c]->ip = printable_ip($l->ip);
	}
	$smarty->assign('refer', $refer);

	$smarty->assign('main','chyby_info');
        return;
    }


if ($w=='add') {
    $cislo=input_num('cislo');
    $text=input_string('text');
    $link=input_string('link');
    $nick=$auth->id;

    db_query(sprintf(
	'INSERT INTO otazky_chyby (cislo,text,link,nick,pridano,stav,ip) VALUES (%d,"%s","%s",%d,now(),"open","%s")',
	$cislo,$text,$link,$nick,$_SERVER['REMOTE_ADDR']
    ));
    
    $smarty->assign('message','Chyba odeslána, dìkujeme');
}

$smarty->assign('main','chyby');
