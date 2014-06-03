<?
if (!$auth->perm_p) {
    error_notperm();
}

$w=input_string('w',array('','pass','perm'));

$smarty->assign('menu','perms');

// --- EDITOR PRAV ---
if ($w=='perm') {
    $w2=input_string('w2',array('','add_perm','del_perm'));

    if (empty($_REQUEST['idn'])) {
        $nick=input_string('nick');
	$fa=db_fquery(sprintf(
	    'SELECT id FROM nicks WHERE LOWER(nick)=LOWER("%s")',
	    $nick
	));
	$idn=$fa[0];
	if (empty($idn)) {
	    show_error('U¾ivatel nenalezen!');
	}
    } else {
	$idn=input_num('idn');
	$fa=db_fquery(sprintf(
	    'SELECT nick FROM nicks WHERE id=%d',
	    $idn
	));
	$nick=$fa[0];
    }
    $smarty->assign('nick',$nick);
    $smarty->assign('idn',$idn);
    
    if ($idn == $auth->id) {
	show_error('Nemù¾ete editovat práva sám sobì');
    }

    if ($w2=='add_perm') {
	$perm=input_char('perm');

	// overeni jestli mam pravo pridat toto pravo
	$fa2=db_fquery(sprintf(
	    'SELECT id FROM perm WHERE perm="%s" AND nick=%d',
	    $perm,$auth->id
	));
	if (empty($fa2[0])) {
	    $smarty->assign('message','Nemù¾ete pøidìlit právo, které sám nemáte');
	    $smarty->assign('message_c','error');
	} else {
    	    // zamezeni duplicit prav
	    $fa=db_fquery(sprintf(
		'SELECT id FROM perm WHERE perm="%s" AND nick=%d',
		$perm,$idn
	    ));
	    if (empty($fa[0])) {
		$q=db_query(sprintf(
		    'INSERT INTO perm (perm,nick) VALUES ("%s",%d)',
		    $perm,$idn
	        ));
		$smarty->assign('message','Právo pøidáno');
		$smarty->assign('message_c','message');
	    } else {
		$smarty->assign('message','U¾ivatel ji¾ toto právo má');
		$smarty->assign('message_c','error');
	    }
	}
    }
    if ($w2=='del_perm') {
	$perm_id=input_num('perm_id');
	
	$fa=db_fquery(sprintf(	
	    'SELECT perm,nick FROM perm WHERE id=%d',
	    $perm_id
	));
	if ($fa['nick'] == $auth->id) {
	    show_error('Nemù¾ete vzít právo sám sobì');
	}
	$fa2=db_fquery(sprintf(
	    'SELECT id FROM perm WHERE perm="%s" AND nick=%d',
	    $fa['perm'],$auth->id
	));
	if (empty($fa2[0])) {
	    $smarty->assign('message','Nemù¾ete odebrat úroveò práva, kterou sám nemáte');
	    $smarty->assign('message_c','error');
	} else {
	    $q=db_query(sprintf(
		'DELETE FROM perm WHERE id=%d LIMIT 1',
		$perm_id
	    ));
	    $smarty->assign('message','Právo odebráno');
	    $smarty->assign('message_c','message');
	}

    }
    
    $q=db_query(sprintf(
	'SELECT perm.id,perm.perm AS letter,pn.name FROM perm LEFT JOIN nicks ON nicks.id=perm.nick LEFT JOIN perm_names pn ON pn.perm=perm.perm WHERE perm.nick=%d ORDER BY letter',
	$idn
    ));
    $smarty->assign('perms',sql2smarty($q,array('id','letter','name')));

    $q=db_query(
	'SELECT perm,name FROM perm_names ORDER BY name'
    );
    $smarty->assign('perm_list',sql2smarty($q,array('perm','name')));
    
    $smarty->assign('main','perms_editor');
    $smarty->assign('title','Práva - editace');
    return;
}

// --- NASTAVENI HESLA PRO WEB ---
if ($w=='pass') {
    $nick=input_string('nick');
    $pass=md5($_REQUEST['pass']);
    db_query(sprintf(
	'UPDATE nicks SET pass="%s" WHERE LOWER(nick)=LOWER("%s")',
	$pass,$nick
    ));
    
    $smarty->assign('message','Heslo nastaveno');
    $smarty->assign('message_c','message');
}

// --- TABULKA PRAV ---
$q=db_query(
    'SELECT perm FROM perm_names ORDER BY perm'
);
$perms_list=sql2smarty($q,array('perm'));

$q=db_query(
    'SELECT perm.perm,n.nick FROM perm LEFT JOIN nicks n ON n.id=perm.nick ORDER BY nick'
);
$perms=sql2smarty($q,array('nick','perm'));
$perms_mat=array();

// Naplneni prazdne tabulky
foreach ($perms as $k=>$v) {
    $perms_mat[$v->nick]=array();
    foreach ($perms_list as $k2=>$v2) {
	$perms_mat[$v->nick][$v2->perm]=false;
    }   
}

// Zapnuti prav ktere maji
foreach ($perms as $k=>$v) {
    $perms_mat[$v->nick][$v->perm]=$v->perm;
}

// Predelani na ciselne indexovane pole
$out=array();
$pos=0;
foreach ($perms_mat as $k=>$v) {
    $out[$pos]=array();
    if ($k != $auth->uname) {
	$out[$pos][0]='<a href="?w=perm&amp;nick='.rawurlencode($k).'">'.HE($k).'</a>';
    } else {
	$out[$pos][0]=HE($k);
    }
    $pos2=1;
    foreach ($perms_mat[$k] as $k2=>$v2) {
	$out[$pos][$pos2]=$perms_mat[$k][$k2];
	$pos2++;
    }
    $pos++;
}

$smarty->assign('perms_count',count($perms_list));
$smarty->assign('perms',$out);

$q=db_query(
    'SELECT perm AS level ,name FROM perm_names ORDER BY level'
);
$smarty->assign('perms_types',sql2smarty($q,array('level','name')));
$smarty->assign('main','perms');
$smarty->assign('title','Práva');
