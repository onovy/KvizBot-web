<h2>Statistiky</h2>
Celkem ot�zek: <b>{$count}</b><br>
Z toho zat�m neschv�leno: <b>{$neschvaleno}</b><br>
<br>
Podle autor� a t�mat:
<table class='table'>
<tr>
    <th>Nick</th>
    <th>T�ma</th>
    <th>Po�et ot�zek</th>
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
Podle t�mat:
<table class='table'>
<tr>
    <th>T�ma</td>
    <th>Po�et ot�zek</td>
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
Podle autor�:
<table class='table'>
<tr>
    <th>Autor</th>
    <th>Po�et ot�zek</th>
</tr>
{section name=sec1 loop=$autori}
<tr>
    <td>{$autori[sec1]->nick|escape}</td>
    <td align='right'>{$autori[sec1]->count}</td>
</tr>
{/section}
</table>
