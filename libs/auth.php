<?php
function my_auth_user() {
    global $auth;
    if ($_REQUEST['page']=='logout') return false;
    $user=db_escape_string($_SERVER['PHP_AUTH_USER']);
    $pass=$_SERVER['PHP_AUTH_PW'];
    if ($user=='' || $_COOKIE['logout']==1) {
	$auth->id=0;
	$auth->uname="";
	return false;
    }
    $f=db_fquery(sprintf(
	'SELECT id FROM nicks WHERE nick="%s" AND pass="%s"',
	$user,md5($pass)
	));
    if (empty($f[0])) {
	$auth->id=0;
	$auth->uname="";
	return false;
    } else {
	$q=db_query(sprintf(
	    'SELECT perm FROM perm WHERE nick=%d',
	    $f[0]
	));
	$auth->perm=array();
	while ($l=db_fetch_array($q)) {
	    eval('$auth->perm_'.$l[0].'=true;');
	}
	$auth->id=$f[0];
	$auth->uname=$user;
	return true;
    }
}

my_auth_user();
$smarty->assign('auth',$auth);
