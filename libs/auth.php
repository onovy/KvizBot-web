<?php
function my_auth_user() {
    global $auth;
    if ($_REQUEST['page']=='logout') return false;
    $user=$_SERVER['PHP_AUTH_USER'];
    $pass=$_SERVER['PHP_AUTH_PW'];
    if ($user=='' || $_COOKIE['logout']==1) {
	$auth = new \stdClass();
	$auth->id=0;
	$auth->uname="";
	return false;
    }

    $f=db_fquery(sprintf(
	'SELECT id, pass2 FROM nicks WHERE nick="%s" AND pass2 IS NOT NULL',
	db_escape_string($user)
	));

    if (empty($f['id'])) {
	$auth = new \stdClass();
	$auth->id=0;
	$auth->uname="";
	return false;
    } else {
	$key = apcu_entry('pass_key', function($key) {
	    return random_bytes(256);
	});
	$apcu_key = 'pass|' . $user . '|' . hash_hmac('sha3-512', $pass, $key);
	if (apcu_fetch($apcu_key) === $f['pass2']) {
	    // Cache
	} elseif (password_verify($pass, $f['pass2'])) {
	    apcu_store($apcu_key, $f['pass2'], 600);
	} else {
	    $auth = new \stdClass();
	    $auth->id=0;
	    $auth->uname="";
	    return false;
	}

	$q=db_query(sprintf(
	    'SELECT perm FROM perm WHERE nick=%d',
	    $f['id']
	));
	$auth->perm=array();
	while ($l=db_fetch_array($q)) {
	    eval('$auth->perm_'.$l[0].'=true;');
	}
	$auth->id=$f['id'];
	$auth->uname=$user;
	return true;
    }
}

my_auth_user();
$smarty->assign('auth',$auth);
