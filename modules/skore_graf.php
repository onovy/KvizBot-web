<?php
header('Content-type: image/png');

$nick = input_num('nick');
$rrdIncome = 'rrd/score/'.$nick.'_income.rrd';
$rrdSum = 'rrd/score/'.$nick.'_sum.rrd';
if (!file_exists($rrdIncome) || !file_exists($rrdSum)) {
    readfile('img/no_graph.png');
    exit;
}

$interval = input_array_noe('interval', array('d', 'w', 'm', 'y', 'a'));
if (!$interval) {
    $interval = 'd';
}
$mult = null;
$label = null;
$start = null;
switch ($interval) {
    case 'd': $start = 'now-1d'; $mult = 1; $label = 'den'; break;
    case 'w': $start = 'now-1w'; $mult = 6; $label = 'tyden'; break;
    case 'm': $start = 'now-1m'; $mult = 24; $label = 'mesic'; break;
    case 'y': $start = 'now-1y'; $mult = 288; $label = 'rok'; break;
    case 'a':
	exec('rrdtool dump ' . escapeshellarg($rrdSum) . ' |grep "<row>" | grep -v " NaN " | cut -d" " -f6 | sort | head -n 1', $out);
	$start = $out[0];
	if (!$start) {
	    readfile('img/no_graph.png');
	    exit;
	}
	$mult = '';
	$label = 'auto';
    break;
}
$out = array();
$ret = 0;
$file = tempnam(sys_get_temp_dir(), 'xkviz');
$w = input_array('w', array('', 'income', 'sum', 'sumMonth'));
if ($w == 'income') {
    exec('rrdtool graph ' . escapeshellarg($file) . ' -W xkviz.net --title '.escapeshellarg('Zisk - ' . $label) . ' --start ' . escapeshellarg($start) . ' --units-exponent 0 --rigid --imgformat PNG --width 350 --height 200 --base 1000 --lower-limit 0 --vertical-label Body '.
    escapeshellarg('DEF:a=' . $rrdIncome . ':income:AVERAGE') . ' '.
    escapeshellarg('CDEF:b=a,'.$mult.',*') . ' '.
    'LINE2:b#00bf00:Bodu '.
    'GPRINT:b:MIN:"   Min\\: %5.1lf %s" '.
    'GPRINT:b:MAX:"   Max\\: %5.1lf %s" '.
    'GPRINT:b:AVERAGE:"   Avg\\: %5.1lf %S\\n" ', $out, $ret);
} else if ($w == 'sum') {
    exec('rrdtool graph ' . escapeshellarg($file) . ' -W xkviz.net --title '.escapeshellarg('Celkove skore - ' . $label) . ' --start ' . escapeshellarg($start) . ' --units-exponent 0 --rigid --imgformat PNG --width 350 --height 200 --base 1000 --lower-limit 0 --vertical-label Body '.
    escapeshellarg('DEF:sum=' . $rrdSum . ':sum:LAST') . ' '.
    'AREA:sum#00bf00:Bodu ',
    $out, $ret);
} else if ($w == 'sumMonth') {
    exec('rrdtool graph ' . escapeshellarg($file) . ' -W xkviz.net --title '.escapeshellarg('Mesicni skore - ' . $label) . ' --start ' . escapeshellarg($start) . ' --units-exponent 0 --rigid --imgformat PNG --width 350 --height 200 --base 1000 --lower-limit 0 --vertical-label Body '.
    escapeshellarg('DEF:sumMonth=' . $rrdSum . ':sumMonth:LAST') . ' '.
    'AREA:sumMonth#00bf00:Bodu ',
    $out, $ret);
}
readfile($file);
unlink($file);
exit;
