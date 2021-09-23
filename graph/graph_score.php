<?php
require_once 'onovyPHPlib/init.php';
$header=false;
require_once 'onovyPHPlib/lib/sql.php';

$m = date('m')-1;
$y = date('Y');
$m_l = $m - 1;
$y_l = $y;
if ($m_l < 0) {
    $y_l -= 1;
    $m_l = 11;
}
$table = 'score_'.$y.'_'.$m;
$table_l = 'score_'.$y_l.'_'.$m_l;
$time=time();
$time=$time-($time%300);

$q = db_query(
    'SELECT s1.nick, n.body, s1.body as body_mesic '.
    'FROM ' . $table . ' s1 '.
    'JOIN nicks n ON (s1.nick = n.id) '.
    'UNION '.
    'SELECT s2.nick, n.body, 0 AS body_mesic '.
    'FROM ' . $table_l . ' s2 '.
    'JOIN nicks n ON (s2.nick = n.id) '.
    'LEFT JOIN ' . $table . ' s3 ON (s2.nick = s3.nick) '.
    'WHERE s3.id IS NULL'
);
while ($line = db_fetch_array($q)) {
    $fileIncome = 'rrd/score/' . $line['nick'] . '_income.rrd';
    $fileSum = 'rrd/score/' . $line['nick'] . '_sum.rrd';
    $score = $line['body'];
    $scoreMonth = $line['body_mesic'];
    
    if (!file_exists($fileIncome)) {
	system('rrdtool create ' . escapeshellarg($fileIncome) . ' ' .
	    '-s 300 ' .
	    'DS:income:COUNTER:600:0:U ' .
	    'RRA:AVERAGE:0.0000001:1:500 ' .
	    'RRA:AVERAGE:0.0000001:6:500 ' .
	    'RRA:AVERAGE:0.0000001:24:500 ' .
	    'RRA:AVERAGE:0.0000001:288:500 '
	);
    }
    if (!file_exists($fileSum)) {
	system('rrdtool create ' . escapeshellarg($fileSum) . ' ' .
	    '-s 300 ' .
	    'DS:sum:GAUGE:600:0:U ' .
	    'DS:sumMonth:GAUGE:600:0:U ' .
	    'RRA:LAST:0.9999999:1:350 ' .
	    'RRA:LAST:0.9999999:2:350 ' .
	    'RRA:LAST:0.9999999:4:350 ' .
	    'RRA:LAST:0.9999999:8:350 ' .
	    'RRA:LAST:0.9999999:16:350 ' .
	    'RRA:LAST:0.9999999:32:350 ' .
	    'RRA:LAST:0.9999999:64:350 ' .
	    'RRA:LAST:0.9999999:128:350 ' .
	    'RRA:LAST:0.9999999:256:350 ' .
	    'RRA:LAST:0.9999999:512:2000 '
	);
    }
    system('rrdupdate ' . escapeshellarg($fileIncome) . ' -t income ' .
	escapeshellarg($time . ':' . ($score*300))
    );
    system('rrdupdate ' . escapeshellarg($fileSum) . ' -t sum:sumMonth ' .
	escapeshellarg($time . ':' . $score . ':' . $scoreMonth)
    );
}
