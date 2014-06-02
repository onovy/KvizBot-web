<?php
$count=0;
function check_table($name,$data,$really)
{
 global $count;
 $count++;
 $errors="";
 $q=db_query_noe('DESCRIBE '.$name);
 if (!$q) {
  $sql="CREATE TABLE ".$name." (";
  $first=1;
  foreach ($data as $v) {
   if ($first) $first=0; else $sql.=', ';
   $sql.=$v['Field'].' ';
   $sql.=$v['Type'].' ';
   $sql.=$v['Add'];
  }
  $sql.=")";
  if ($really) {
   db_query($sql);
   return '<font style="color: blue">Tabulka '.$name.' vytvoøena</font>'."\n";
  } else 
   return '<font style="color: red">Tabulka '.$name.' neexistuje</font>'."\n";
 }
 $data_db=array();
 while ($l=db_fetch_array($q)) {
  $data_db[]=$l;
  $found=false;
  foreach ($data as $value) {
   $value['Type']=strtr($value['Type'],'"','\'');
   if ($l['Field']==$value['Field']) {
    if ($l['Type']!=$value['Type']) {
     // Typ pole nesedi
     if ($really) {
      db_query('ALTER TABLE '.$name.' CHANGE '.$l['Field'].' '.$l['Field'].' '.$value['Type']);
      $errors.='Polo¾ka '.$l['Field'].' opravena'."\n";
     } else {
      $errors.='Polo¾ka '.$l['Field'].' má v DB typ '.$l['Type'].', ale v definici je '.$value['Type']."\n";
     }
    }
    $found=true;
    break;
   }
  }
  if (!$found) {
   if ($really) {
    db_query('ALTER TABLE '.$name.' DROP '.$l['Field']);
    $errors.='Polo¾ka '.$l['Field'].' odebrána z DB'."\n";
   } else {
    $errors.='Polo¾ka '.$l['Field'].' nenalezena v definici'."\n";
   }  
  }
 }
 
 foreach ($data as $value) {
  $found=false;
  foreach ($data_db as $value_db) {
   if ($value['Field']==$value_db['Field']) $found=true;
  }
  if (!$found) {
   if ($really) {
    db_query('ALTER TABLE '.$name.' ADD '.$value['Field'].' '.$value['Type'].' '.$value['Add']);
    $errors.='Polo¾ka '.$value['Field'].' pøidána do DB'."\n";
   } else {
    $errors.='Polo¾ka '.$value['Field'].' nenalezena v DB'."\n";
   }
  }
 }
 if (empty($errors)) {
  $errors='<font style="color: green">Tabulka '.$name.' je vpoøádku'."</font>\n";
 } else {
  if ($really)
   $errors='<font style="color: blue">Opravy v tabulce '.$name.":\n".$errors."</font>\n";
  else
   $errors='<font style="color: red">Chyby v tabulce '.$name.":\n".$errors."</font>\n";
 }

 return $errors;
}

function modules_sql_init(&$errors) {
    global $lib_config;
    global $really;

    if (defined('MODULE_AUTH')) { // Vytvoreni tabulek pro modul AUTH
	// USERS
	$errors.=check_table($lib_config['mlib_auth_table_name'],array(
    	    array( 'Field' => 'id',
    	           'Type'  => 'int(11)',
	           'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
	    array( 'Field' => 'user',
	           'Type'  => 'varchar(50)'),
	    array( 'Field' => 'pass',
	           'Type'  => 'varchar(32)'),
	    array( 'Field' => 'last_action',
	           'Type'  => 'datetime'),
	),$really);
	
	$count=db_fquery_noe('SELECT COUNT(*) FROM '.$lib_config['mlib_auth_table_name']);
	if ($count !== false && $count[0] == 0) {
	    if ($really) {
	        $errors.="<font style='color: blue'>Generuji u¾ivatele pro modul AUTH:\n";
		$pass = substr(md5(rand()%1000 . '_onovyPHPlib_' . time()),0,6);
	        db_query(sprintf(
	    	    'INSERT INTO '.$lib_config['mlib_auth_table_name'].' (user,pass) VALUES ("admin","%s")',
		    md5($pass)
		));
		$errors.=" U¾. jméno: <strong>admin</strong>\n Heslo: <strong>".$pass."</strong></font>\n";
	    } else {
		$errors.="<font style='color: red'>Neexistuje ¾ádný u¾ivatel pro modul AUTH</font>\n";
	    }
	}
    }

    if (defined('MODULE_TEXTY')) { // Vytvoreni tabulek pro modul TEXTY
	// TEXTY
	$errors.=check_table($lib_config['mlib_texty_table_name'],array(
	    array( 'Field' => 'id',
	           'Type'  => 'int(11)',
	           'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
	    array( 'Field' => 'txt',
	           'Type'  => 'text'),
	    ),$really);
	// vytvoreni zaznamu uvnitr tabulky
	$count=db_fquery_noe('SELECT COUNT(*) FROM '.$lib_config['mlib_texty_table_name']);
	if ($count !== false &&
	    $count[0] < $lib_config['mlib_texty_count'] &&
	    !empty($lib_config['mlib_texty_count'])
	    ) {
	    $add=$lib_config['mlib_texty_count'] - $count[0];
	    if ($add>4) $zazn='ù';
		elseif ($add>1) $zazn='y';
		    else $zazn='';

	    
	    if ($really) {
	        for ($a=0 ; $a<$add ; $a++) {
		    db_query('INSERT INTO '.$lib_config['mlib_texty_table_name'].' (txt) VALUES ("")');
	        }
		if ($add>4) $prid='o';
		    elseif ($add>1) $prid='y';
			else $prid='';
		$errors.="<font style='color: blue'>Do tabulky pro modul TEXTY byl".$prid." pøidán".$prid." ".($add)." záznam".$zazn."</font>\n";
	    } else {
		$errors.="<font style='color: red'>V tabulce pro modul TEXTY chybí ".($add)." záznam".$zazn."</font>\n";
	    }
	}
    }
}

?>