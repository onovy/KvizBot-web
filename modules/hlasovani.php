<?php
$w=input_array('w',array('','hlas',
    'add_otazka','add_otazka2','add_odpoved','add_odpoved2','active','deactive','ips'
));

$smarty->assign('menu','hlasovani');
$smarty->assign('title','Hlasování');

if ($auth->perm_t) {
    $otazka='';

    if ($w=='add_otazka') {
	$smarty->assign('w','add_otazka2');
	$smarty->assign('main','hlasovani_add');
	return;	
    }

    if ($w=='add_otazka2') {
	$otazka=input_string('otazka');
	$min_score=input_num('min_score');
	db_query(sprintf(
	    'INSERT INTO hlasovani (otazka,active,min_score) VALUES ("%s",0,%d)',
	    $otazka, $min_score
	));
	$otazka=db_insert_id();
	$smarty->assign('message','Otázka pøidána');
	$smarty->assign('message_c','message');
	$w='add_odpoved';
    }

    if ($w=='add_odpoved2') {
	$otazka=input_num('otazka');
	$odpoved=input_string('odpoved');
	
	db_query(sprintf(
	    'INSERT INTO hlasovani_odpovedi (otazka,odpoved) VALUES (%d,"%s")',
	    $otazka,$odpoved
	));
	
	if (input_checkbox('next')) {
	    $w='add_odpoved';
	}

	$smarty->assign('message','Odpovìï pøidána');
	$smarty->assign('message_c','message');
    }

    if ($w=='add_odpoved') {
	if (empty($otazka)) {
	    $otazka=input_num('otazka');
	}
	
	$fa=db_fquery(sprintf(
	    'SELECT otazka FROM hlasovani WHERE id=%d',
	    $otazka
	));
	$smarty->assign('otazka',$fa[0]);

	$smarty->assign('otazka_id',$otazka);
	
	$smarty->assign('w','add_odpoved2');
	$smarty->assign('main','hlasovani_odp_add');
	return;
    }

    if ($w=='active') {
	$id=input_num('hlasovani');
	
	db_query(sprintf(
	    'UPDATE hlasovani SET active=1,timestmp=timestmp WHERE id=%d',
	    $id
	));
	$smarty->assign('message','Hlasování aktivováno');
	$smarty->assign('message_c','message');
    }

    if ($w=='deactive') {
	$id=input_num('hlasovani');
	
	db_query(sprintf(
	    'UPDATE hlasovani SET active=0,timestmp=timestmp WHERE id=%d',
	    $id
	));
	$smarty->assign('message','Hlasování deaktivováno');
	$smarty->assign('message_c','message');
    }
}

if ($auth->perm_a) {
    if ($w == 'ips') {
	$otazka=input_num('otazka');
	$q=db_query(sprintf(
	    'SELECT hlasovani_hlasy.id,ip,ip_rev,hlasovani_odpovedi.odpoved,hlasovani_hlasy.nick AS nick_id,'.
	    'nicks.nick '.
	    'FROM hlasovani_hlasy '.
	    'JOIN hlasovani_odpovedi ON hlasovani_hlasy.odpoved=hlasovani_odpovedi.id '.
	    'LEFT JOIN nicks ON hlasovani_hlasy.nick=nicks.id '.
	    'WHERE hlasovani_hlasy.otazka=%d '.
	    'ORDER BY hlasovani_hlasy.odpoved,ip',
	    $otazka
	));
	$hlasy = sql2smarty($q, array('id', 'odpoved', 'nick', 'nick_id', 'ip', 'ip_rev'));
	foreach ($hlasy as $k=>$hlas) {
	    if (empty($hlasy[$k]->ip_rev)) {
	        $hlasy[$k]->ip_rev = gethostbyaddr($hlas->ip);
		db_query(sprintf(
		    'UPDATE hlasovani_hlasy SET ip_rev="%s" WHERE id=%d',
		    $hlasy[$k]->ip_rev, $hlas->id
		));
	    }
	}
	$smarty->assign('hlasy', $hlasy);
	$smarty->assign('main', 'hlasovani_ips');
	return;
    }
}

if ($w=='hlas') {
    $odpoved=input_num('odpoved');
    $otazka=input_num('otazka');
    $hlasuj=true;

    // active otazka
    $fa2=db_fquery(sprintf(
	'SELECT id, min_score FROM hlasovani WHERE id=%d AND active=1',
	$otazka
    ));
    if (empty($fa2['id'])) $hlasuj=false;
    $min_score = $fa2['min_score'];
    
    // otazka vs. odpoved
    $fa2=db_fquery(sprintf(
	'SELECT otazka FROM hlasovani_odpovedi WHERE id=%d',
	$odpoved
    ));
    if ($fa2['otazka']!=$otazka) $hlasuj=false;

    // overeni IP
    $fa2=db_fquery(sprintf(
	'SELECT id FROM hlasovani_hlasy WHERE otazka=%d AND ip="%s"',
	$otazka,$_SERVER['REMOTE_ADDR']
    ));
    if (!empty($fa2['id'])) $hlasuj=false;
    
    // overeni nicku
    $fa2=db_fquery(sprintf(
	'SELECT id FROM hlasovani_hlasy WHERE otazka=%d AND nick=%d',
	$otazka,$auth->id
    ));
    if (!empty($fa2['id'])) $hlasuj=false;
    
    // overeni min_score
    if ($min_score) {
	$fa2=db_fquery(sprintf(
	    'SELECT body FROM nicks WHERE id=%d',
	    $auth->id
	));
	if ($fa2['body'] < $min_score) $hlasuj=false;
    }

    // hlasovani
    if ($hlasuj) {
	db_query(sprintf(
	    'INSERT INTO hlasovani_hlasy (otazka,odpoved,nick,ip) VALUES (%d,%d,%d,"%s")',
	    $otazka,$odpoved,$auth->id,$_SERVER['REMOTE_ADDR']
        ));
	$smarty->assign('message','Díky za hlas');
	$smarty->assign('message_c','message');
    } else {
	$smarty->assign('message','Nemù¾ete hlasovat vícekrát nebo nesplòujete podmínky hlasování');
	$smarty->assign('message_c','error');
    }
}

if (!empty($_GET['inactive'])) {
    $where = '';
} else {
    $where = 'WHERE active=1';
}
$q_otazky=db_query('SELECT id,otazka,active,min_score FROM hlasovani '.$where.' ORDER BY timestmp DESC');
$otazky=array();
$pos=0;
while ($fa=db_fetch_array($q_otazky)) {
    $q=db_query(sprintf(
	'SELECT ho.id,ho.odpoved,COUNT(hh.id) AS hlasu FROM hlasovani_odpovedi ho LEFT JOIN hlasovani_hlasy hh ON ho.id=hh.odpoved WHERE ho.otazka=%d GROUP BY ho.id ORDER BY ho.id',
	$fa['id']
    ));
    $odpovedi=sql2smarty($q,array('id','odpoved','hlasu'));

    $sum=0;
    foreach ($odpovedi as $c=>$l) {
	$sum+=$l->hlasu;
    }
    foreach ($odpovedi as $c=>$l) {
	if ($sum!=0) {
	    $odpovedi[$c]->procenta=round($l->hlasu/$sum*100,2);
	    $odpovedi[$c]->width=round($l->hlasu/$sum*200);
        } else {
	    $odpovedi[$c]->procenta=0;
	    $odpovedi[$c]->width=1;
	}
    }

    $otazky[$pos]->id=$fa['id'];
    $otazky[$pos]->otazka=$fa['otazka'];
    $otazky[$pos]->active=$fa['active'];
    $otazky[$pos]->min_score=$fa['min_score'];
    $otazky[$pos]->odpovedi=$odpovedi;
    $pos++;
}

$smarty->assign('otazky',$otazky);

$smarty->assign('main','hlasovani');
