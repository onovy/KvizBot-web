<?
require_once 'onovyPHPlib/init.php';
$header=false;
require_once 'onovyPHPlib/lib/sql.php';

$count=db_fquery('SELECT COUNT(*) FROM online');
$count=$count[0];
system('rrdupdate rrd/online.rrd '.(time()).':"'.$count.'"');


system('rrdtool graph rrd/online.png -W xkviz.net --title "Online" --start now-1d --units-exponent 0 --rigid --imgformat PNG --width 576 --height 200 --base 1000 --lower-limit 0 --vertical-label Count '.
'DEF:a=rrd/online.rrd:data:AVERAGE '.
'LINE2:a#00aa00:Users '.
'GPRINT:a:MIN:"         Min\\: %5.1lf %s" '.
'GPRINT:a:MAX:"     Max\\: %5.1lf %s" '.
'GPRINT:a:AVERAGE:"     Avg\\: %5.1lf %S\\n" ');

$same =
'-W xkviz.net --units-exponent 0 --rigid --imgformat PNG --width 576 --height 200 --base 1000 --lower-limit 0 --vertical-label Count '.
'DEF:a=rrd/online.rrd:data:AVERAGE '.
'DEF:b=rrd/online.rrd:data:MAX '.
'DEF:c=rrd/online.rrd:data:MIN '.
'CDEF:bc=b,c,- '.
'LINE:c#aaffaa:"Users min" '.
'GPRINT:c:MIN:"     Min\\: %5.1lf %s" '.
'GPRINT:c:MAX:"     Max\\: %5.1lf %s" '.
'GPRINT:c:AVERAGE:"     Avg\\: %5.1lf %S\\n" '.
'AREA:bc#aaffaa:"Users max":STACK '.
'GPRINT:b:MIN:"     Min\\: %5.1lf %s" '.
'GPRINT:b:MAX:"     Max\\: %5.1lf %s" '.
'GPRINT:b:AVERAGE:"     Avg\\: %5.1lf %S\\n" '.
'LINE2:a#00aa00:Users '.
'GPRINT:a:MIN:"         Min\\: %5.1lf %s" '.
'GPRINT:a:MAX:"     Max\\: %5.1lf %s" '.
'GPRINT:a:AVERAGE:"     Avg\\: %5.1lf %S\\n" '
;
system('rrdtool graph rrd/online_week.png --title "Online week" --start now-1w ' . $same);
system('rrdtool graph rrd/online_month.png --title "Online month" --start now-1m ' . $same);
system('rrdtool graph rrd/online_year.png --title "Online year" --start now-1y ' . $same);

?>
