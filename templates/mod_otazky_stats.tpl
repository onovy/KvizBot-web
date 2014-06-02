<h2>Statistiky</h2>
Celkem otázek: <b>{$count}</b><br>
Z toho zatím neschváleno: <b>{$neschvaleno}</b><br>
<br>
Podle autorù a témat:
<table class='table'>
<tr>
    <th>Nick</th>
    <th>Téma</th>
    <th>Poèet otázek</th>
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
    <th>Poèet otázek</td>
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
Podle autorù:
<table class='table'>
<tr>
    <th>Autor</th>
    <th>Poèet otázek</th>
</tr>
{section name=sec1 loop=$autori}
<tr>
    <td>{$autori[sec1]->nick|escape}</td>
    <td align='right'>{$autori[sec1]->count}</td>
</tr>
{/section}
</table>
