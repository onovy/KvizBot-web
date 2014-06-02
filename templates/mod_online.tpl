<h2>{$title|escape}</h2>

<strong>Celkem hráèù online:</strong> {$count}<br />
<table class='table'>
<tr>
    <th>Nick</th>
    <th>Nick</th>
    <th>Nick</th>
    <th>Nick</th>
{section name=sec1 loop=$online}
{if $smarty.section.sec1.index%4 == 0}</tr><tr>{/if}
    <td>
	{if $online[sec1]->med == 1}
	    <img src='img/gold-small.png' alt='Gold' />
	{/if}
	{if $online[sec1]->med == 2}
	    <img src='img/silver-small.png' alt='Silver' />
	{/if}
	{if $online[sec1]->med == 3}
	    <img src='img/bronze-small.png' alt='Bronze' />
	{/if}
	{if $online[sec1]->medm == 1}
	    <img src='img/gold-small.png' alt='Gold' />
	{/if}
	{if $online[sec1]->medm == 2}
	    <img src='img/silver-small.png' alt='Silver' />
	{/if}
	{if $online[sec1]->medm == 3}
	    <img src='img/bronze-small.png' alt='Bronze' />
	{/if}
	{if $online[sec1]->id!=''}
	    <a href='skore.htm?w=info&amp;user={$online[sec1]->id}'>
	{/if}
	    {if $online[sec1]->id == $auth->id}
		<strong>
	    {/if}
	    {$online[sec1]->nick|escape}
	    {if $online[sec1]->id == $auth->id}
		</strong>
	    {/if}
	{if $online[sec1]->id!=''}
	    </a>
	{/if}
    </td>
{/section}
{if $smarty.section.sec1.total%4 == 1}<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>{/if}
{if $smarty.section.sec1.total%4 == 2}<td>&nbsp;</td><td>&nbsp;</td>{/if}
{if $smarty.section.sec1.total%4 == 3}<td>&nbsp;</td>{/if}
</tr>
</table>

<br />

<img src='rrd/online.png' alt='Graf online u¾ivatelù' /><br />
<img src='rrd/online_week.png' alt='Graf online u¾ivatelù' /><br />
<img src='rrd/online_month.png' alt='Graf online u¾ivatelù' /><br />
<img src='rrd/online_year.png' alt='Graf online u¾ivatelù' /><br />
<small>
<a href='/rrd/online.rrd' >RRD</a>
</small>
