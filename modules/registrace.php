<?php

$w = input_array('w', array('', 'hash', 'password','password2'));

if ($w == 'hash') {
    $ok = true;

    $nick = input_string('nick');

    // Nick ID
    $q = db_query(sprintf(
	'SELECT id FROM nicks WHERE nick="%s"',
	$nick
    ));
    $id = db_fetch_array($q);
    if (!$id) {
	$smarty->assign('message', 'Nick neexistuje, nebo nem� ��dn� body!');
	$smarty->assign('message_c', 'error');
	$ok = false;
    }
    
    if ($ok) {
	$id = $id['id'];
	
	$q = db_query(sprintf(
	    'SELECT id FROM online WHERE nick="%s"',
	    $nick
	));
	$fa = db_fetch_array($q);
	if (!$fa) {
	    $smarty->assign('message', 'Nick nen� v m�stnosti!');
	    $smarty->assign('message_c', 'error');
	    $ok = false;
	}
    }
    
    if ($ok) {
	$q = db_query(sprintf(
	    'SELECT id FROM pass_req WHERE (nick="%s" OR ip="%s") AND sent=false',
	    $nick, db_escape_string($_SERVER['REMOTE_ADDR'])
	));
	$fa = db_fetch_array($q);
	if ($fa) {
	    $smarty->assign('message', 'Po�adavek byl ji� odesl�n!');
	    $smarty->assign('message_c', 'error');
	    $ok = false;
	}
    }
    
    if ($ok) {
	$hash = substr(md5(getmypid() . '-' . time() . '-' . rand() . '-' . $nick), 0, 8);
	db_query(sprintf(
	    'INSERT INTO pass_req (nick, hash, ip) VALUES (%d, "%s", "%s")',
	    $id, db_escape_string($hash), db_escape_string($_SERVER['REMOTE_ADDR'])
	));
    
	$smarty->assign('message', 'Registrace vytvo�ena');
	$smarty->assign('message_c', 'message');
	$smarty->assign('main', 'registrace_hash');
    } else {
	$w = '';
    }
}

if ($w == 'password' || $w == 'password2') {
    // Clean HASHes - 1 hour later
    db_query('DELETE FROM pass_req WHERE sent=true AND used=false AND UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(added)>3600');

    $ok = true;
    
    $hash = input_string('hash');
    
    $q = db_query(sprintf(
        'SELECT id, nick, ip, sent, used FROM pass_req WHERE hash="%s"',
        $hash
    ));
    $fa = db_fetch_array($q);
    if (!$fa) {
	$smarty->assign('message', '�patn� k�d!');
	$smarty->assign('message_c', 'error');
	$ok = false;
    }
    
    if ($ok) {
	if (!$fa['sent']) {
	    $smarty->assign('message', 'K�d nebyl je�t� zasl�n!');
	    $smarty->assign('message_c', 'error');
	
	    $ok = false;
	}
    }
    
    if ($ok) {
	if ($fa['used']) {
	    $smarty->assign('message', 'K�d byl ji� pou�it!');
	    $smarty->assign('message_c', 'error');
	
	    $ok = false;
	}
    }
    
    if ($ok) {
	if ($fa['ip'] != $_SERVER['REMOTE_ADDR']) {
	    $smarty->assign('message', 'Potvrzen� registrace je nutn� d�lat ze stejn� IP!');
	    $smarty->assign('message_c', 'error');
	
	    $ok = false;
	}
    }

    if (($w == 'password2') && ($_REQUEST['pass'] != $_REQUEST['pass2'])) {
	$smarty->assign('message', 'Hesla nesouhlas�');
	$smarty->assign('message_c', 'error');
	$w = 'password';
    }

    if ($ok) {
	if ($w == 'password') {
	    $smarty->assign('hash', $hash);
	    $smarty->assign('main', 'registrace_password');
	} else {
	    $password = md5($_REQUEST['pass']);

	    db_query(sprintf(
		'UPDATE nicks SET pass="%s" WHERE id = %d',
		db_escape_string($password), $fa['nick']
	    ));
	    	
	    db_query(sprintf(
		'UPDATE pass_req SET used = TRUE WHERE id = %d',
		$fa['id']
	    ));

	    $smarty->assign('message', 'Heslo nastaveno');
	    $smarty->assign('message_c', 'message');
	    $smarty->assign('main', 'registrace_password2');
	}
    } else {
	$w = '';
    }    
}

if ($w == '') {
    $smarty->assign('main', 'registrace');
}

$smarty->assign('menu', 'registrace');
$smarty->assign('title', 'Registrace');
