<?php
if (!empty($local_config['http_redir_with_prefix'])) {
    $prefix = $local_config['http_redir_with_prefix'];
    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $http = ($_SERVER['HTTPS']?'https':'http');
    if (substr($url,0,strlen($prefix)) != $prefix) {
	header('Location: '.$http.'://'.$prefix.$url);
	exit;
    }
}
    

header('Expires: ' . date('r',time()-3600));
header('Cache-Control: private');
header('Cache-Control: max-age=0');
header('Content-Type: text/html;charset=' . $lib_config['charset']);
