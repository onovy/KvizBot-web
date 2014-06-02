<?
require_once 'onovyPHPlib/init.php';
require_once 'onovyPHPlib/main.php';
require_once 'onovyPHPlib/lib/sql_init.php';

$really=input_string('really');

$errors='';

modules_sql_init($errors);

// NICKS
$errors.=check_table('nicks',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'nick',
	'Type'  => 'varchar(50)'),
 array( 'Field' => 'pass',
	'Type'  => 'varchar(32)'),
 array( 'Field' => 'body',
	'Type'  => 'int(11)'),
 array( 'Field' => 'added',
	'Type'  => 'datetime'),
 array( 'Field' => 'last',
	'Type'  => 'timestamp'),
 ),$really);

// PERM
$errors.=check_table('perm',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'nick',
	'Type'  => 'int(11)'),
 array( 'Field' => 'perm',
	'Type'  => 'char(1)'),
 ),$really);

// PERM_NAMES
$errors.=check_table('perm_names',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'perm',
	'Type'  => 'char(1)'),
 array( 'Field' => 'name',
	'Type'  => 'varchar(100)'),
 ),$really);

// ONLINE
$errors.=check_table('online',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'nick',
	'Type'  => 'varchar(50)'),
 ),$really);

// OTAZKY
$errors.=check_table('otazky',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'otazka',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'odpoved',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'owner',
	'Type'  => 'int(11)'),
 array( 'Field' => 'tema',
	'Type'  => 'int(11)'),
 array( 'Field' => 'schvaleni',
	'Type'  => 'int(11)'),
 array( 'Field' => 'last',
	'Type'  => 'datetime'),
 array( 'Field' => 'change_tema',
	'Type'  => 'int(11)'),
 array( 'Field' => 'change_otazka',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'change_odpoved',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'change_comment',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'game',
	'Type'  => 'int(11)'),
 ),$really);

// TEMATA
$errors.=check_table('temata',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'nazev',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'hidden',
	'Type'  => 'tinyint(4)'),
 ),$really);

// AKTUALITY
$errors.=check_table('aktuality',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'nazev',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'text',
	'Type'  => 'blob'),
 array( 'Field' => 'autor',
	'Type'  => 'int(11)'),
 array( 'Field' => 'timestmp',
	'Type'  => 'timestamp'),
 ),$really);

// HLASOVANI
$errors.=check_table('hlasovani',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'otazka',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'timestmp',
	'Type'  => 'timestamp'),
 array( 'Field' => 'active',
	'Type'  => 'tinyint(1)'),
 ),$really);

// HLASOVANI_ODPOVEDI
$errors.=check_table('hlasovani_odpovedi',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'otazka',
	'Type'  => 'int(11)'),
 array( 'Field' => 'odpoved',
	'Type'  => 'varchar(100)'),
 ),$really);

// HLASOVANI_HLASY
$errors.=check_table('hlasovani_hlasy',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'odpoved',
	'Type'  => 'int(11)'),
 array( 'Field' => 'ip',
	'Type'  => 'varchar(15)'),
 array( 'Field' => 'ip_rev',
	'Type'  => 'varchar(128)'),
 array( 'Field' => 'otazka',
	'Type'  => 'int(11)'),
 ),$really);

// OTAZKY_CHYBY
$errors.=check_table('otazky_chyby',array(
 array( 'Field' => 'id',
	'Type'  => 'int(11)',
	'Add' => 'PRIMARY KEY AUTO_INCREMENT'),
 array( 'Field' => 'cislo',
	'Type'  => 'int(11)'),
 array( 'Field' => 'text',
	'Type'  => 'blob'),
 array( 'Field' => 'link',
	'Type'  => 'varchar(200)'),
 array( 'Field' => 'stav',
	'Type'  => 'enum("open","close","unconfirmed")'),
 array( 'Field' => 'pridano',
	'Type'  => 'datetime'),
 array( 'Field' => 'uzavreno',
	'Type'  => 'datetime'),
 array( 'Field' => 'nick',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'email',
	'Type'  => 'varchar(100)'),
 array( 'Field' => 'ip',
	'Type'  => 'varchar(15)'),
 ),$really);

$errors.="\nCelkem tabulek: ".$count;

$smarty->assign('errors',$errors);
$smarty->assign('really',$really);
$smarty->assign('title','Inicializace databáze');
$smarty->assign('main','db_init');
$smarty->assign('main_onovyPHPlib',1);

$smarty->display('main.tpl');
?>