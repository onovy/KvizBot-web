<h2>{$title|escape}</h2>

{if $auth->id != 0}
<a href='skore.htm?w=info&user={$auth->id|escape}'>Moje skóre</a>
{/if}

<form method='get' action='skore.htm'>
<fieldset>
Hledat: <input type='text' name='nick' />
<input type='hidden' name='w' value='search' />
<input type='submit' value='Hledat' />
</fieldset>
</form>

{if !$topmenu}
<div style='float: left;'>
{/if}
TOP celkového skóre:<br />
<br />
<table class='table'>
    <tr>
	<th>P</th>
	<th>Nick</th>
	<th>Body</th>
    </tr>
{section name=sec1 loop=$top_all}
    <tr>
	<td align='right'>{$smarty.section.sec1.index+1}.</td>
	<td>
	{if $smarty.section.sec1.index == 0}
	    <img src='/img/gold-small.png' alt='Gold' />
	{/if}
	{if $smarty.section.sec1.index == 1}
	    <img src='/img/silver-small.png' alt='Silver' />
	{/if}
	{if $smarty.section.sec1.index == 2}
	    <img src='/img/bronze-small.png' alt='Bronze' />
	{/if}
	<a href='?w=info&amp;user={$top_all[sec1]->id}'>{$top_all[sec1]->nick|escape}</a></td>
	<td align='right'>{$top_all[sec1]->body}</td>
    </tr>
{/section}
</table>

{if !$topmenu}
</div>

<div style='float: right;'>
{else}
<br /><br />
{/if}

TOP mìsíèního skóre:<br />
{$top_month_name_p} |
<strong>{$top_month_name|escape}</strong> |
{$top_month_name_n}<br />
<table class='table'>
    <tr>
	<th>P</th>
	<th>Nick</th>
	<th>Body</th>
    </tr>
{section name=sec1 loop=$top_month}
    <tr>
	<td align='right'>{$smarty.section.sec1.index+1}.</td>
	<td>
	{if $smarty.section.sec1.index == 0}
	    <img src='/img/gold-small.png' alt='Gold' />
	{/if}
	{if $smarty.section.sec1.index == 1}
	    <img src='/img/silver-small.png' alt='Silver' />
	{/if}
	{if $smarty.section.sec1.index == 2}
	    <img src='/img/bronze-small.png' alt='Bronze' />
	{/if}	
	<a href='?w=info&amp;user={$top_month[sec1]->id}'>{$top_month[sec1]->nick|escape}</a></td>
	<td align='right'>{$top_month[sec1]->body}</td>
    </tr>
{/section}
</table>

{if !$topmenu}
</div>
{/if}