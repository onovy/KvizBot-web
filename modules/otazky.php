<?

function space_seen($text) {
    return str_replace(' ', '<font color="red">+</font><wbr/>', htmlspecialchars($text, null, 'ISO8859-1'));
}

function check_otazka($otazka,$odpoved,$tema) {
    // TODO: Overovani podle pravidel pro otazky
    if ($otazka=='') return 'Musíte zadat otázku';
    if ($odpoved=='') return 'Musíte zadat odpovìï';
    if ($tema==0) return 'Vyberte téma';
    
    // otazka OK
    return '';
}

function schval_otazku($id) {
    db_query(sprintf(
	'UPDATE otazky SET otazka=change_otazka,odpoved=change_odpoved,tema=change_tema,change_otazka="",change_odpoved="",change_tema=0,schvaleni=0,last=now() WHERE id=%d and schvaleni != 0',
	$id
    ));
}

$smarty->assign('menu','otazky');
$smarty->assign('title','Otázky');

$w=input_array('w',array('','add','add2','schvaleni','id','search','edit','add_tema','stats','temata','list','del'));
if ($auth->perm_o) {
    if ($w=='add' || $w=='add2' || $w=='id') {
	$smarty->assign('pravidla',get_text(3)); // Pravidla pro psani otazek
    }
    
    if ($w=='add2') {
	$otazka=input_string('otazka');
	$odpoved=input_string('odpoved');
	$tema=input_num('tema');
	
	// overeni otazky a odpovedi
	$msg=check_otazka($otazka,$odpoved,$tema);
	if ($msg=='') {
	    if ($auth->perm_a) {
		$schvaleni=input_num('schvaleni');
	    } else {
		$schvaleni=-1;
	    }
	    $q=db_query(sprintf(
		'INSERT INTO otazky (change_otazka,change_odpoved,schvaleni,change_tema,owner,game) VALUES ("%s","%s",%d,%d,%d,3)',
		$otazka,$odpoved,$schvaleni == 0 ? -1 : $schvaleni,$tema,$auth->id
	    ));
    	    if ($q) {
	        $message='<font color="green">Otázka pøidána</font>';
	    } else {
		$message='<font color="red">Otázka nebyla pøidána</font>';
	    }
	    $smarty->assign('message',$message);
    	    if ($schvaleni==0)
	        schval_otazku(db_insert_id());
	    $smarty->assign('message','<font color="green">Otázka pøidána</font>');
	} else {
	    $smarty->assign('message','<font color="red">'.$msg.'</font>');
	    $smarty->assign('otazka',$otazka);
	    $smarty->assign('odpoved',$odpoved);
	    $smarty->assign('tema',$tema);
	}
	$w='add';
    }

    // realna editace otazky
    if ($w=='edit') {
	$id=input_num('id');
	$otazka=input_string('otazka');
	$odpoved=input_string('odpoved');
	$tema=input_num('tema');
	$comment=input_string('comment');

	// overeni otazky a odpovedi
	$msg=check_otazka($otazka,$odpoved,$tema);
	if ($msg=='') {
	    if (!$auth->perm_a) {
		if (!$auth->perm_v) {
		    $fa=db_fquery(sprintf(
			'SELECT owner FROM otazky WHERE id=%d',
			$id
		    ));
		    if ($fa['owner']!=$auth->id) {
			$smarty->assign('main','no_access');
			$smarty->assign('main_onovyPHPlib',1);
			return;
		    }
		}
		$schvaleni=-1;
	    } else {
		$schvaleni=input_num('schvaleni');
	    }
	
    	    db_query(sprintf(
		'UPDATE otazky SET change_otazka="%s",change_odpoved="%s",change_tema=%d,schvaleni=%d,change_comment="%s" WHERE id=%d',
		$otazka,$odpoved,$tema,$schvaleni == 0 ? -1 : $schvaleni,$comment,$id
	    ));
	
	    if ($schvaleni==0) {
		schval_otazku($id);
	    }
	    $smarty->assign('message','<font color="green">Otázka upravena</font>');
	} else {
	    $w='id';
	    $smarty->assign('message','<font color="red">'.$msg.'</font>');
	}
    }

    if ($w=='add') {
	// listovani temat
	$q=db_query('SELECT id,nazev FROM temata WHERE hidden=0 ORDER BY nazev');
	$smarty->assign('temata',sql2smarty($q,array('id','nazev')));

	// listovani schvalovacu
	if ($auth->perm_a) {
	    $q=db_query('SELECT n.id,n.nick FROM perm p LEFT JOIN nicks n ON p.nick=n.id WHERE perm="v" ORDER BY n.nick');
	    $smarty->assign('schvaleni',sql2smarty($q,array('id','nick')));
	}
	
	$smarty->assign('main','otazky_add');
	return;
    }
    
    // fulltext
    if ($w=='search') {
	$text=input_string('text');
	if ($text!='' && $text!=' ') {
	    if ($auth->perm_v) {
		$where='';
	    } else {
		$where=' AND owner='.$auth->id;
	    }
	    $q=db_query(sprintf(
		'SELECT id,otazka,odpoved,change_otazka,change_odpoved FROM otazky WHERE '.
							   '(otazka LIKE "%%%s%%" OR '.
							    'odpoved LIKE "%%%s%%" OR '.
							    'change_odpoved LIKE "%%%s%%" OR '.
							    'change_otazka LIKE "%%%s%%")'.$where.
							    ' LIMIT 200',
		$text,$text,$text,$text
	    ));
	    $result=sql2smarty($q,array('id','otazka','odpoved','change_odpoved','change_otazka'));
	    foreach ($result as $c=>$l) {

		if ($l->change_otazka!='') {
		    $odpoved=$l->otazka;
		    $l->otazka ='<font color="red">'.HE($l->otazka).'</font><br>';
		    $l->otazka.='<font color="green">'.HE($l->change_otazka).'</font><br>';
		}

		if ($l->change_odpoved!='') {
		    $odpoved=$l->odpoved;
		    $l->odpoved ='<font color="red">'.HE($l->odpoved).'</font><br>';
		    $l->odpoved.='<font color="green">'.HE($l->change_odpoved).'</font><br>';
		}

		$result[$c]->otazka = preg_replace('/(' . $text . ')/i', '<b>\\1</b>', $l->otazka);
		$result[$c]->odpoved = preg_replace('/(' . $text . ')/i', '<b>\\1</b>', $l->odpoved);
	    }
	
	    $smarty->assign('result',$result);
    
	    $smarty->assign('text',$text);
	    $smarty->assign('main','otazky_search');
	    return;
	}
    }

    // editace otazky
    if ($w=='id') {
	$id=input_num('id');
	
	$comment=input_string('comment');
	$smarty->assign('comment',$comment);
	
	if ($auth->perm_v) {
	    $where='';
	} else {
	    $where=' AND owner='.$auth->id;
	}
	$fa=db_fquery(sprintf(
	    'SELECT otazky.id,otazka,odpoved,tema,owner,change_otazka,change_odpoved,change_tema,temata.nazev AS tema_nazev,game FROM otazky LEFT JOIN temata ON temata.id=otazky.tema WHERE otazky.id=%d'.$where,
	    $id
	));

	// listovani temat
	$q=db_query('SELECT id,nazev FROM temata WHERE hidden=0 ORDER BY nazev');
	$smarty->assign('temata',sql2smarty($q,array('id','nazev')));

	if ($fa['id']=='') {
	    $smarty->assign('main','no_access');
	    $smarty->assign('main_onovyPHPlib',1);
	    return;
	}

	// listovani schvalovacu
	if ($auth->perm_a) {
	    $q=db_query('SELECT n.id,n.nick FROM perm p LEFT JOIN nicks n ON p.nick=n.id WHERE perm="v" ORDER BY n.nick');
	    $schvaleni=sql2smarty($q,array('id','nick'));
	    $pos=count($schvaleni);
	    
	    $fa2=db_fquery(sprintf(
		'SELECT nick FROM nicks WHERE id=%d',
		$fa['owner']
	    ));
	    $schvaleni[$pos]->id = $fa['owner'];
	    $schvaleni[$pos]->nick = '- autor -';
	    $schvaleni[$pos+1]->id = $fa['owner'];
	    $schvaleni[$pos+1]->nick = $fa2['nick'];
	    $smarty->assign('schvaleni',$schvaleni);
	}

	$smarty->assign('id',$id);
	$smarty->assign('otazka',$fa['otazka']);
	$smarty->assign('odpoved',$fa['odpoved']);
	$smarty->assign('otazka_s',space_seen($fa['otazka']));
	$smarty->assign('odpoved_s',space_seen($fa['odpoved']));
	$smarty->assign('tema',$fa['tema']);
	$smarty->assign('tema_nazev',$fa['tema_nazev']);
	if ($fa['change_otazka']=='') $fa['change_otazka']=$fa['otazka'];
	if ($fa['change_odpoved']=='') $fa['change_odpoved']=$fa['odpoved'];
	if ($fa['change_tema']=='') $fa['change_tema']=$fa['tema'];
	$smarty->assign('change_otazka',$fa['change_otazka']);
	$smarty->assign('change_odpoved',$fa['change_odpoved']);
	$smarty->assign('change_tema',$fa['change_tema']);
	$smarty->assign('owner',$fa['owner']);
	$smarty->assign('game',$fa['game']);

	$smarty->assign('main','otazky_edit');
	return;
    }
    
    if ($w=='list') {
    	if ($_REQUEST['tema']!='') {
	    $tema=input_num('tema');
	    if ($auth->perm_v) {
		// listovani vsech otazek
		$q=db_query(sprintf(
		    'SELECT id,otazka,odpoved,game FROM otazky WHERE tema=%d ORDER BY id',
		    $tema
		));
	    } else {
		// listovani vsech otazek uzivatele
		$q=db_query(sprintf(
		    'SELECT id,otazka,odpoved,game FROM otazky WHERE tema=%d AND owner=%d ORDER BY id',
		    $tema,$auth->id
		));
	    }
	    $smarty->assign('otazky',sql2smarty($q,array('id','otazka','odpoved','game')));

	    $smarty->assign('main','otazky_list2');
	} else {
	    if ($auth->perm_v) {
		// listovani vsech temat
		$q=db_query(
		    'SELECT temata.id,nazev,count(otazky.id) AS pocet FROM temata LEFT JOIN otazky ON otazky.tema=temata.id GROUP BY otazky.tema ORDER BY temata.nazev'
		);
	    } else {
		// listovani temat uzivatele
		$q=db_query(sprintf(
		    'SELECT temata.id,nazev,count(otazky.id) AS pocet FROM temata LEFT JOIN otazky ON otazky.tema=temata.id WHERE otazky.owner=%d GROUP BY otazky.tema ORDER BY temata.nazev',
		    $auth->id
		));
	    }
	    $smarty->assign('temata',sql2smarty($q,array('id','nazev','pocet')));

	    $smarty->assign('main','otazky_list');
	}
	return;
    }
}

if ($auth->perm_a) {
    if ($w=='del') {
	$param = input_string('id');
	$where = '';
	$ids = explode(',', $param);
	foreach ($ids as $id) {
	    $ok=0;
	    if (is_numeric($id)) {
		if (!empty($where)) $where .= ' OR ';
		$where .= sprintf('(id=%d)', $id);
		$ok = 1;
	    } else {
		$pos = strpos($id, '-');
		if ($pos) {
		    $id1 = substr($id, 0, $pos);
		    $id2 = substr($id, $pos+1);
		    if (is_numeric($id1) && is_numeric($id2)) {
			if ($id1 > $id2) {
			    $tmp = $id2;
			    $id2 = $id1;
			    $id1 = $tmp;
			}
			if (!empty($where)) $where .= ' OR ';
			$where .= sprintf('(id>=%d AND id<=%d)', $id1, $id2);
			$ok=1;
		    }
		}
	    }
	    if (!$ok) {
		$smarty->assign('mazani_message', '<font color="red">©patný formát èísla otázky</font>');
		break;
	    }
	}
	if ($ok) {
	    $q=db_query(sprintf(
	    	'UPDATE otazky SET game=0 WHERE %s',
	    	$where
	    ));
	    if (db_affected_rows()>=1) {
		$smarty->assign('mazani_message', '<font color="green">Deaktivováno podle ' .
		    $where. ' ' . db_affected_rows() . ' otázek</font>');
	    } else {
		$smarty->assign('mazani_message', '<font color="red">Otázka neexistuje</font>');
	    }
	}
    }
}

// realne schvaleni
if ($w=='schvaleni') {
    if ($auth->perm_a) {
	$schvaleni_admin = ' OR schvaleni=-1';
    } else {
        $schvaleni_admin='';
    }
    $q=db_query(sprintf(
	'SELECT otazky.id FROM otazky WHERE schvaleni=%d'.$schvaleni_admin,
	$auth->id
    ));
    $count=0;
    while ($l=db_fetch_array($q)) {
	$sch=input_checkbox($l['id']);
	if ($sch) {
	    schval_otazku($l['id']);
	    $count++;
	}
    }
    $smarty->assign('schvaleni_message','<font color="green">Schváleno '.$count.' otázek</font>');
}

// schvaleni
if ($auth->id!=0) {
    if ($auth->perm_a) {
	$schvaleni_admin = 'OR schvaleni=-1';
    } else {
        $schvaleni_admin='';
    }
    $q=db_query(sprintf(
	'SELECT otazky.id,otazka,odpoved,change_otazka,change_odpoved,o_temata.nazev AS tema,ch_temata.nazev AS change_tema,nicks.nick AS user,change_comment AS comment FROM otazky LEFT JOIN temata AS o_temata ON o_temata.id=otazky.tema LEFT JOIN temata AS ch_temata ON ch_temata.id=otazky.change_tema LEFT JOIN nicks ON nicks.id=otazky.owner WHERE game > 0 AND (schvaleni=%d '.$schvaleni_admin.') ORDER BY otazky.owner,otazky.tema,otazky.id',
	$auth->id
    ));
    $schvaleni=array();
    $pos=0;
    while ($l=db_fetch_array($q)) {
	$schvaleni[$pos]->id=$l['id'];
	$schvaleni[$pos]->user=$l['user'];
	$schvaleni[$pos]->comment=$l['comment'];

	if ($l['otazka']!=$l['change_otazka']) {
	    $schvaleni[$pos]->otazka ='';	
	    if ($l['otazka']!='')
		$schvaleni[$pos]->otazka.='<font color="red">'.space_seen($l['otazka']).'</font><br>';
	    $schvaleni[$pos]->otazka.='<font color="green">'.space_seen($l['change_otazka']).'</font>';
	} else {
	    $schvaleni[$pos]->otazka=space_seen($l['otazka']);
	}

	if ($l['odpoved']!=$l['change_odpoved']) {
	    $schvaleni[$pos]->odpoved ='';
	    if ($l['odpoved']!='')
		$schvaleni[$pos]->odpoved.='<font color="red">'.space_seen($l['odpoved']).'</font><br>';
	    $schvaleni[$pos]->odpoved.='<font color="green">'.space_seen($l['change_odpoved']).'</font>';
	} else {
	    $schvaleni[$pos]->odpoved=space_seen($l['odpoved']);
	}
	
	if ($l['tema']!=$l['change_tema']) {
	    $schvaleni[$pos]->tema ='';
	    if ($l['tema']!='')
		$schvaleni[$pos]->tema.='<font color="red">'.HE($l['tema']).'</font><br>';
	    $schvaleni[$pos]->tema.='<font color="green">'.HE($l['change_tema']).'</font>';
	} else {
	    $schvaleni[$pos]->tema=HE($l['tema']);
	}
	
	$pos++;
    }
    $smarty->assign('schvaleni',$schvaleni);
}

// temata
if ($w=='temata') {
    if ($auth->perm_a) {
	$w2=input_array('w2',array('','add'));
        if ($w2=='add') {
    	    $nazev=input_string('nazev');
	    $hidden=input_checkbox('hide');
	    db_query(sprintf(
		'INSERT INTO temata (nazev,hidden) VALUES ("%s",%d)',
		$nazev,$hidden
	    ));
	}

	$q=db_query('SELECT id,nazev,hidden FROM temata ORDER BY nazev');
	$smarty->assign('temata_list',sql2smarty($q,array('id','nazev','hidden')));
	
	$smarty->assign('main','otazky_temata');
	return;
    }
}

// statistiky
if ($w=='stats') {
    // statistiky podle autoru a temat
    $q=db_query('SELECT nicks.nick AS nick,COUNT(otazky.id) AS count,temata.nazev AS tema FROM otazky LEFT JOIN nicks ON otazky.owner=nicks.id LEFT JOIN temata ON otazky.tema=temata.id WHERE game > 0 GROUP BY otazky.tema,nicks.id ORDER BY nicks.nick,temata.nazev');
    $smarty->assign('nicks',sql2smarty($q,array('nick','count','tema')));

    // statistiky podle temat
    $q=db_query('SELECT COUNT(otazky.id) AS count,temata.nazev AS tema FROM otazky LEFT JOIN temata ON otazky.tema=temata.id WHERE game > 0 GROUP BY otazky.tema ORDER BY count DESC');
    $smarty->assign('temata',sql2smarty($q,array('count','tema')));

    // statistiky podle autoru
    $q=db_query('SELECT nicks.nick AS nick,COUNT(otazky.id) AS count FROM otazky LEFT JOIN nicks ON otazky.owner=nicks.id WHERE game > 0 GROUP BY nicks.nick ORDER BY count DESC');
    $smarty->assign('autori',sql2smarty($q,array('nick','count')));

    // celkovy pocet otazek
    $fa=db_fquery('SELECT COUNT(*) FROM otazky WHERE game > 0');
    $smarty->assign('count',$fa[0]);

    // celkovy pocet neschv. otazek
    $fa=db_fquery('SELECT COUNT(*) FROM otazky WHERE game > 0 AND schvaleni!=0');
    $smarty->assign('neschvaleno',$fa[0]);

    $smarty->assign('main','otazky_stats');
    return;
}


$smarty->assign('main','otazky');
?>
