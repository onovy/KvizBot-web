<?php
/**
 * Modul pro konverzi textu (novejsi verze)
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_OT2HTML',1);

$simple_tags=array(
    'B'=>array(
	'open'=>'<strong>',
	'close'=>'</strong>'
    ),
    'I'=>array(
	'open'=>'<i>',
	'close'=>'</i>'
    ),
    'U'=>array(
	'open'=>'<span style="text-decoration: underline;">',
	'close'=>'</span>'
    ),
    'COLOR'=>array(
	'open'=>'<span style="color: %1;">',
	'close'=>'</span>'
    ),
    'SIZE'=>array(
	'open'=>'<p style="font-size: %1em;">',
	'close'=>'</p>'
    ),
    'A'=>array(
	'open'=>'<a href="%1">',
	'close'=>'</a>'
    ),
);

$maxh=5;

/**
 * Konverze textu na HTML (novejsi verze)
 *
 * @param $input - vstupni text
 * @return zkonvertovany text
 */
function ot2html($in,$use_cache=true) {
    global $maxh;

    $md5 = md5($in);
    if (defined('MODULE_CACHE') && $use_cache) {
	$cache = cache_getcache('ot2html',$md5);
	if ($cache) {
	    return $cache;
	}
    }
    
    // Typografie a escape
    if (defined('MODULE_TYPO')) {
	$in = typo(htmlspecialchars($in, null, 'ISO8859-1'),false);
    } else {
	$in = htmlspecialchars($in, null, 'ISO8859-1');
    }
    
    $lines = explode("\r\n", $in);
    $out = "<p>\n";
    $seznam_open = false;
    $seznam_typ = '';
    
    foreach ($lines as $l) {
	// Seznamy
	if ($l[0] == '*' || $l[0] == '#') {
	    if ($table_open) {
		ot2html_table_close($out);
		$table_open = false;
	    }

	    $seznam_typ=$l[0];
	    if (!$seznam_open) {
		$seznam_open=true;
		$out .= "</p>\n";
		if ($seznam_typ == '*') {
		    $out .= "\n<ul>\n";
		} else {
		    $out .= "\n<ol>\n";
		}
	    }
	    $out .= '<li>' . ot2html_simple_tags(substr($l,1)) . "</li>\n";
	    continue;
	} else {
	    if ($seznam_open) {
		ot2html_seznam_close($out,$seznam_typ);
		$seznam_open=false;
	    }
	}

	// Tabulky
	if ($l[0]=='^' || $l[0]=='|') {
	    $s=$l;
	    if (!$table_open) {
		$out .= "\n</p>\n\n<table class='ot' cellspacing='0' cellpadding='4'>\n";
		$table_open = true;
	    }
	    $out .= "<tr>\n";
	    $pos=true;
	    while ($pos) {
		$type = $s[0];
		if ($type == '^') {
		    $out .= '<th>';
		} else {
		    $out .= '<td>';
		}

		$s=substr($s,1);
		$pos1=strpos($s,'|');
		$pos2=strpos($s,'^');
		if ($pos1 == $pos2) $pos=$pos1; else
		if ($pos1 === false) $pos=$pos2; else
		if ($pos2 === false) $pos=$pos1; else
		if ($pos1 < $pos2) $pos=$pos1; else
		if ($pos1 > $pos2) $pos=$pos2;

		if ($pos === false) {
		    $out .= $s;
		} else {
		    $out .= substr($s,0,$pos);
		    $s = substr($s,$pos);
		}

	        if ($type == '^') {
		    $out .= '</th>';
		} else {
		    $out .= '</td>';
	        }
	    }
	    $out .= "\n</tr>\n";
	    continue;
	} else {
	    if ($table_open) {
		ot2html_table_close($out);
		$table_open = false;
	    }
	}

	// HR
	if ($l == '&#8211;&#8211;') {
	    $out .= "<hr />\n";
	    continue;
	}
	// H(3-$maxh)
	if (str_startsWith($l,'==')) {
	    $h=str_findFirstNotOf($l,'=');
	    if ($h == -1) {
		$out .= $l;
		continue;
	    } 
	    $text = substr($l,$h ,strlen($l) - ($h*2));
	    $h = $h + 1;
	    if ($h>$maxh) $h = $maxh;
	    $out .= "</p>\n<h" . $h . '>' . ot2html_simple_tags($text) . '</h' . $h . '>' . "\n<p>\n";
	    continue;
	}
	
	// Odstavce
	if (empty($l)) {
	    $out .= "\n</p><p>\n";
	    continue;
	}

	// Simple_tags
	$out .= ot2html_simple_tags($l);
    }

    if ($seznam_open) {
	ot2html_seznam_close($out,$seznam_typ);
    }
    
    if ($table_open) {
	ot2html_table_close();
    }

    $out .= "\n</p>\n";

    // BR
    $out = str_replace('\\\\',"<br />\n",$out);

    if (defined('MODULE_CACHE') && $use_cache) {
	cache_putcache('ot2html',$md5,$out);
    }

    return $out;
}

function ot2html_seznam_close(&$out,$seznam_typ) {
    if ($seznam_typ == '*') {
	$out .= "</ul>\n";
    } else {
	$out .= "</ol>\n";
    }
    $out .= "<p>\n";
}

function ot2html_table_close(&$out) {
    $out .= "</table>\n\n<p>\n";
}

function ot2html_simple_tags($l) {
    global $simple_tags;

    $out = '';

    $start = true;
    while (!($start === false)) {
	$start = strpos($l,'[');
        if (!($start === false)) {
    	    $out .= substr($l,0,$start);
	    $open = !($l[$start+1] == '/');
	    $link = ($l[$start+1] == '[');
	    $tmp = substr($l,$start + ($open?0:1));
	    $len = strpos($tmp,']');
	    $tag = substr($tmp,1 + ($link?1:0),$len - 1 - ($link?1:0));
    	    $params = explode(' ',$tag);
    	    $l = substr ($l,$start + $len + 1 + ($open?0:1) + ($link?1:0));
	    if ($link) { // Odkaz
		if (empty($params[1])) {
		    $title=$params[0];
		} else {
		    $tmp=$params;
		    $tmp[0]='';
		    $title=implode(' ',$tmp);
		}
		$zavinac = strpos($params[0],'@');
		if ($zavinac) {
		    $link = 'mailto:' . rawurlencode($params[0]);
		} else {
		    $link = $params[0];
		}
		$out .= '<a href="' . $link . '">' . HE($title) . '</a>';
		continue;
	    }
	    foreach ($simple_tags as $key => $htag) {
	        if (strtolower($key) == strtolower($params[0])) {
		    $htag_out = $htag[($open?'open':'close')];
		    for ($a=1 ; $a<sizeof($params) ; $a++) {
			$htag_out = str_replace('%'.$a,$params[$a],$htag_out);
		    }

		    $out .= $htag_out;
	    	}
	    }
	}
    }
    $out .= $l.' ';
    
    return $out;
}

?>
