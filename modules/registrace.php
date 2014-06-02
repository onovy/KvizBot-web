<?

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
	$smarty->assign('message', 'Nick neexistuje, nebo nemá ¾ádné body!');
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
	    $smarty->assign('message', 'Nick není v místnosti!');
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
	    $smarty->assign('message', 'Po¾adavek byl ji¾ odeslán!');
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
    
	$smarty->assign('message', 'Registrace vytvoøena');
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
	$smarty->assign('message', '©patný kód!');
	$smarty->assign('message_c', 'error');
	$ok = false;
    }
    
    if ($ok) {
	if (!$fa['sent']) {
	    $smarty->assign('message', 'Kód nebyl je¹tì zaslán!');
	    $smarty->assign('message_c', 'error');
	
	    $ok = false;
	}
    }
    
    if ($ok) {
	if ($fa['used']) {
	    $smarty->assign('message', 'Kód byl ji¾ pou¾it!');
	    $smarty->assign('message_c', 'error');
	
	    $ok = false;
	}
    }
    
    if ($ok) {
	if ($fa['ip'] != $_SERVER['REMOTE_ADDR']) {
	    $smarty->assign('message', 'Potvrzení registrace je nutné dìlat ze stejné IP!');
	    $smarty->assign('message_c', 'error');
	
	    $ok = false;
	}
    }

    if (($w == 'password2') && ($_REQUEST['pass'] != $_REQUEST['pass2'])) {
	$smarty->assign('message', 'Hesla nesouhlasí');
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

	    // PhpBB
	    if (!empty($local_config['phpbb_sql_user']) && !empty($local_config['phpbb_sql_pass']) && !empty($local_config['phpbb_sql_host'])) {
		$uname = db_fquery(sprintf(
		    'SELECT nick FROM nicks WHERE id = %d',
		    $fa['nick']
		));
		$uname = mysql_escape_string($uname[0]);

		$db_link2 = mysql_connect($local_config['phpbb_sql_host'],$local_config['phpbb_sql_user'],$local_config['phpbb_sql_pass']) or show_error('Doslo k chybe pri pripojovani k databazi, omlouvame se');
		mysql_select_db($local_config['phpbb_sql_name'], $db_link2) or show_error('Doslo k chybe pri vybirani databaze, omlouvame se');
		// Exists?
		$q = mysql_query(sprintf(
		    'SELECT user_id FROM phpbb_users WHERE username = "%s"',
		    $uname
    		), $db_link2);
		$fa = mysql_fetch_array($q);
		if ($fa) {
		    // Update
		    mysql_query(sprintf(
			'UPDATE phpbb_users SET user_password = "%s" WHERE user_id = "%s"',
			mysql_real_escape_string($password, $db_link), $fa['user_id']
    		    ), $db_link2) or show_error("Chyba SQL: ".mysql_error());
		} else {
		    // ID
		    $fa = mysql_fetch_array(mysql_query(
			'SELECT MAX(user_id) FROM phpbb_users',
    			$db_link2)) or show_error("Chyba SQL: ".mysql_error());
		    // Create
		    mysql_query(sprintf(
			'INSERT INTO phpbb_users (user_id, username, user_email, user_password, user_regdate) VALUES (%d, "%s", "", "%s", unix_timestamp())',
			$fa[0]+1, $uname, mysql_real_escape_string($password, $db_link)
    		    ), $db_link2) or show_error("Chyba SQL: ".mysql_error());
		}
		mysql_close($db_link2);
	    }
	    	
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
?>