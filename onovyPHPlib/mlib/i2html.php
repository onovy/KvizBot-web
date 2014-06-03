<?php
/**
 * Modul pro konverzi textu
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_I2HTML',1);

/**
 * Konverze textu na HTML
 *
 * @param $input - vstupni text
 * @param $typo - provadet typografickou upravu? true/false
 * @return zkonvertovany text
 */
function i2html($input,$typo=true) {
 $s=htmlspecialchars($input, null, 'ISO8859-1');

 if ($typo && defined('MODULE_TYPO')) {
    $s=typo($s);
 }

 $ends = array ("[a " => "[/a]",
		"[a_nw " => "[/a]",
		"[b]"=> "[/b]",
		"[i]"=> "[/i]",
		"[u]"=> "[/u]",
		"[color "=> "[/color]",
		"[size "=> "[/size]",
		"[h1]"=> "[/h1]",
		"[h2]"=> "[/h2]",
		"[h3]"=> "[/h3]",
		"[h4]"=> "[/h4]",
		"[table]"=> "[/table]",
		"[tr]"=> "[/tr]",
		"[td]"=> "[/td]",
 );

 $s_low=strtolower($s);
 foreach($ends as $begin => $end) {
  $count = substr_count($s_low, $begin) - substr_count($s_low, $end);
  if($count > 0)
   $s .= str_repeat($end, $count);
 }
 
 $s=stri_replace("[b]","<strong>",$s);
 $s=stri_replace("[/b]","</strong>",$s);
 $s=stri_replace("[i]","<i>",$s);
 $s=stri_replace("[/i]","</i>",$s);
 $s=stri_replace("[u]","<span style='text-decoration: underline;'>",$s);
 $s=stri_replace("[/u]","</span>",$s);
 $s=stri_replace("[h1]","<h1>",$s);
 $s=stri_replace("[/h1]","</h1>",$s);
 $s=stri_replace("[h2]","<h2>",$s);
 $s=stri_replace("[/h2]","</h2>",$s);
 $s=stri_replace("[h3]","<h3>",$s);
 $s=stri_replace("[/h3]","</h3>",$s);
 $s=stri_replace("[h4]","<h4>",$s);
 $s=stri_replace("[/h4]","</h4>",$s);
 $s=stri_replace("[br]","<br />",$s);
 $s=stri_replace("[table]","<table>",$s);
 $s=stri_replace("[/table]","</table>",$s);
 $s=stri_replace("[tr]","<tr>",$s);
 $s=stri_replace("[/tr]","</tr>",$s);
 $s=stri_replace("[td]","<td>",$s);
 $s=stri_replace("[/td]","</td>",$s);
 $s=preg_replace("/\[img (.*?)\]/i","<img src=\"/img/c/\\1\" alt='Obrazek' />",$s);
 $s=preg_replace("/\[img_l (.*?)\]/i","<img src=\"/img/c/\\1\" class='left' alt='Obrazek' />",$s);
 $s=preg_replace("/\[img_thumb (.*?)\]/i","<a href=\"/img/c/\\1\"><img src=\"/img/c/thumb/\\1\" alt='Obrazek' /></a>",$s);
 $s=preg_replace("/\[a (.*?)\]/i","<a href=\"\\1\">",$s);
 $s=preg_replace("/\[a_nw (.*?)\]/i","<a href=\"\\1\" onclick=\"window.open(this.href,'_blank');return false;\">",$s);
 $s=preg_replace("/\[color (.*?)\]/i","<span style=\"color: \\1;\">",$s);
 $s=preg_replace("/\[size (.*?)\]/i","<p style=\"font-size: \\1em\">",$s);
 $s=stri_replace("[/a]","</a>",$s);
 $s=stri_replace("[/color]","</span>",$s);
 $s=stri_replace("[/size]","</p>",$s);

 // aktivni promenne
 if (strpos($s,'{poslední zmìna}')) {
    $fa=db_fquery('SELECT DATE_FORMAT(last_action,"%d. %m. %Y") FROM admins ORDER BY admins.last_action DESC LIMIT 1');
    $s=stri_replace("{poslední zmìna}",$fa[0],$s);
 }
 
 
 // seznamy
 $arr=explode("\n",$s);
 $open=false;
 foreach ($arr as $pos=>$l) {
    if (strlen($l)==1) {
	$arr[$pos]="\n</p><p>\n";
    } else {
	$sub=substr($l[0],0,1);
	if ($sub=='*' || $sub=='#') {
	    $open_type=$sub;
	    $arr[$pos]=substr($arr[$pos],1);
	    if (!$open) {
		$open=true;
		if ($sub=='*') {
	    	    $arr[$pos]="<ul><li>".$arr[$pos]."</li>";
		} else {
	    	    $arr[$pos]="<ol><li>".$arr[$pos]."</li>";
		}
	    } else {
		$arr[$pos]="<li>".$arr[$pos]."</li>";
	    }
	} else {
	    if ($open) {
		if ($open_type=="*") {
		    $arr[$pos]="</ul>".$arr[$pos];
		} else {
		    $arr[$pos]="</ol>".$arr[$pos];
		}
	    }
	    $open=false;
	    $arr[$pos]=$arr[$pos]."<br />";
	}
    }
 }
 $s=implode("\n",$arr);
 if ($open) $s.='</ul>';
 
 return $s;
}
