<?php

// c1154cfab7ec68c5681a596bc99b380d
$hash=md5('sldkfjgkl3456xsb');

$thash=input_string('hash');

if ($thash!=$hash) {
    print 'Bad hash, sorry';
    exit;
}

$q=db_query(
    'SELECT odpoved,otazka FROM otazky WHERE schvaleni=0 AND (game & 2) != 0 ORDER BY id'
);

while ($l=db_fetch_array($q)) {
    print $l['odpoved']."|".$l['otazka']."\n";
}
exit;
