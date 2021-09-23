<?php
require_once 'onovyPHPlib/init.php';
require_once 'onovyPHPlib/main.php';

$page=input_array_noe('page',array(
    '','uvod','pravidla','login','logout','spravci','aktuality','hlasovani',
    'skore','online','perms','otazky','chyby','pravidla_otazky',
    'licence-otazek','stats', 'registrace', 'skore_graf'
));
if ($page === false) {
    show_error('Stránka nenalezena!');
}
if (empty($page)) $page='uvod';
if (!empty($_GET['topmenu'])) {
    $smarty->assign('topmenu', 1);
}

include 'modules/'.$page.'.php';


$smarty->display('main.tpl');
