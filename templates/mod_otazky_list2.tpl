<a href='?w=list'>Zp�t</a><br><br>

<table class='table'>
<tr>
    <th>ID</th>
    <th>Ot�zka</th>
    <th>Odpov��</th>
    <th>Hra</th>
</tr>
{section name=sec1 loop=$otazky}
<tr>
    <td>
	<a href='?w=id&amp;id={$otazky[sec1]->id}'>
	    {$otazky[sec1]->id}
	</a>
    </td>
    <td>
        {$otazky[sec1]->otazka|escape}
    </td>
    <td>
        {$otazky[sec1]->odpoved|escape}
    </td>
    <td>
	{if $otazky[sec1]->game==1}
	    Xchat
	{elseif $otazky[sec1]->game==2}
	    IRC
	{elseif $otazky[sec1]->game==3}
	    Xchat+IRC
	{else}
	    Deakt.
	{/if}
    </td>
</tr>
{/section}
</table