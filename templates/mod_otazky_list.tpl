<a href='?w='>Zp�t</a><br><br>

{section name=sec1 loop=$temata}
<a href='?w=list&amp;tema={$temata[sec1]->id}'>{$temata[sec1]->nazev|escape}</a> ({$temata[sec1]->pocet})<br />
{/section}
