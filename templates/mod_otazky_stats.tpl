<h2>Statistiky</h2>
Celkem otázek: <b>{$count}</b><br>
Z toho zatím neschváleno: <b>{$neschvaleno}</b><br>
<br>
Podle autorů a témat:
<table class='table'>
<tr>
    <th>Nick</th>
    <th>Téma</th>
    <th>Počet otázek</th>
</tr>
{section name=sec1 loop=$nicks}
<tr>
    <td>{$nicks[sec1]->nick|escape}</td>
    <td>{$nicks[sec1]->tema|escape}</td>
    <td align='right'>{$nicks[sec1]->count}</td>
</tr>
{/section}
</table>

<br>
Podle témat:
<table class='table'>
<tr>
    <th>Téma</td>
    <th>Počet otázek</td>
</tr>
{section name=sec1 loop=$temata}
<tr>
    <td>
 	{if $temata[sec1]->tema|escape}
    	    {$temata[sec1]->tema|escape}
	{else}
	    - neschvaleno -
	{/if}
    </td>
    <td align='right'>{$temata[sec1]->count}</td>
</tr>
{/section}
</table>

<br>
Podle autorů:
<table class='table'>
<tr>
    <th>Autor</th>
    <th>Počet otázek</th>
</tr>
{section name=sec1 loop=$autori}
<tr>
    <td>{$autori[sec1]->nick|escape}</td>
    <td align='right'>{$autori[sec1]->count}</td>
</tr>
{/section}
</table>
