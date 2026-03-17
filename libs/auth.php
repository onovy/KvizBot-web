<?php
function my_auth_user() {
    global $auth;
    if (($_REQUEST['page'] ?? null) =='logout') return false;
    $user=$_SERVER['PHP_AUTH_USER'] ?? null;
    $pass=$_SERVER['PHP_AUTH_PW'] ?? null;
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

	$auth = new \stdClass();
	$q=db_query(sprintf(
	    'SELECT perm FROM perm WHERE nick=%d',
	    $f['id']
	));
	$auth->perm=array();
	while ($l=db_fetch_array($q)) {
	    $perm = $l[0];
	    if (preg_match('/^[a-z]$/', $perm)) {
		$auth->{'perm_' . $perm} = true;
	    }
	}
	$auth->id=$f['id'];
	$auth->uname=$user;
	return true;
    }
}

function auth_show401() {
    global $smarty;

    header('WWW-Authenticate: Basic realm="Autorizace"');
    header('HTTP/1.0 401 Unauthorized');
    setcookie("logout", 0, ["path" => "/", "secure" => true, "httponly" => true, "samesite" => "Strict"]);

    $smarty->assign('title','Autorizace selhala');
    $smarty->assign('main','no_access');
    $smarty->assign('main_onovyPHPlib',1);
    $smarty->display('main.tpl');
    exit;
}

my_auth_user();
$smarty->assign('auth',$auth);
