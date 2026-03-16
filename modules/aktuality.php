<?php

$w=input_array('w',array('','add','del'));
if ($auth->perm_w ?? null) {
    if ($w=='add') {
        csrf_verify();
        $nazev=input_string('nazev');
        $text=input_string('text');

        db_query(sprintf(
            'INSERT INTO aktuality (nazev,text,autor) VALUES ("%s","%s",%d)',
            $nazev,$text,$auth->id
        ));
        $smarty->assign('message','Přidána');
        $smarty->assign('message_c','message');
    }

    if ($w=='del') {
        csrf_verify();
        $id=input_num('id');
        db_query(sprintf(
            'DELETE FROM aktuality WHERE id=%d',
            $id
        ));
        $smarty->assign('message','Smazána');
        $smarty->assign('message_c','message');
    }
}

$offset=input_num_0('offset');
$smarty->assign('offset', $offset);
$q=db_query(sprintf(
    'SELECT aktuality.id,nazev,text,timestmp,DATE_FORMAT(timestmp,"%%d. %%m. %%Y %%H:%%i") AS kdy,nicks.nick AS autor FROM aktuality LEFT JOIN nicks ON aktuality.autor=nicks.id ORDER BY aktuality.timestmp DESC LIMIT 10 OFFSET %d',
    $offset
));
$aktuality=sql2smarty($q,array('id','nazev','text','kdy','autor'));
foreach ($aktuality as $c=>$l) {
    $aktuality[$c]->text=ot2html($l->text);
}
$smarty->assign('aktuality',$aktuality);

$smarty->assign('menu','aktuality');
$smarty->assign('title','Aktuality');
$smarty->assign('main','aktuality');
