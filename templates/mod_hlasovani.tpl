<h2>{$title|escape}</h2>

{include file="../onovyPHPlib/templates/message.tpl"}

{if $auth->perm_t}
    <a href='?w=add_otazka'>P�idat ot�zku</a><br />
{/if}

Ve�ker� p�ipom�nky a n�pady k XKv�zu sm��ujte do <a href="/forum/">f�ra</a><br />
<br />
<strong>U ka�d�ho hlasov�n� je nutn� hlasovat zvlṻ!</strong><br />
<strong>Ur�it� hlasov�n� je podm�n�no p�ihl�en�m a z�sk�n�m ur�it�ho po�tu bod�</strong><br />
<br />
<a href='hlasovani.htm?inactive=1'>Zobrazit i neaktivn�</a>
<br />
{section name=sec1 loop=$otazky}
<strong>
{$otazky[sec1]->otazka|escape}
</strong>
<br />
{if $otazky[sec1]->min_score!=0}
Minim�ln� po�et bod�: {$otazky[sec1]->min_score|escape}
{/if}
{if $auth->perm_t}
    {if $otazky[sec1]->active}
	<a href='?w=deactive&amp;hlasovani={$otazky[sec1]->id}'>Deaktivovat</a>
    {else}
	<a href='?w=active&amp;hlasovani={$otazky[sec1]->id}'>Aktivovat</a>
    {/if}
    | <a href='?w=add_odpoved&amp;otazka={$otazky[sec1]->id}'>P�idat odpov��</a>
    | <a href='?w=ips&amp;otazka={$otazky[sec1]->id}'>Hlasy</a>
{/if}
<br />
<table border='0'>
{if $otazky[sec1]->active}
    <form method='post'>
    <input type='hidden' name='otazka' value='{$otazky[sec1]->id}' />
{/if}
{section name=sec2 loop=$otazky[sec1]->odpovedi}
<tr>
    <td style='width: 20px'>
	{if $otazky[sec1]->active}
	    <input type='radio' name='odpoved' value='{$otazky[sec1]->odpovedi[sec2]->id}'>
	{/if}
    </td>
    <td>{$otazky[sec1]->odpovedi[sec2]->odpoved|escape}</td>
    <td>({$otazky[sec1]->odpovedi[sec2]->hlasu})</td>
    <td><img src='img/bar.gif' alt='Bar' width='{$otazky[sec1]->odpovedi[sec2]->width}' height='15' /> {$otazky[sec1]->odpovedi[sec2]->procenta}&nbsp;%</td>
</tr>
{/section}
<tr>
    <td></td>
    <td colspan='2'>
	{if $otazky[sec1]->active}
	    <input type='submit' value='Hlasovat' />
	{/if}
    </td>
    <td></td>
</tr>
{if $otazky[sec1]->active}
    <input type='hidden' name='w' value='hlas' />
    </form>
{/if}
</table>
<br />
{/section}