<h2>Skóre - info o hráèi</h2>
<h3>
    Nick:
    <a href='https://xchat.cz/whoiswho/profile.php?nick={$nick|escape:"url"}'>
	<img src='https://scripts.xchat.cz/scripts/online_img.php?nick={$nick|escape:"url"}'></a>

    {if $pozice == 1}
        <img src='/img/gold.png' alt='Gold' />
    {/if}
    {if $pozice == 2}
        <img src='/img/silver.png' alt='Silver' />
    {/if}
    {if $pozice == 3}
        <img src='/img/bronze.png' alt='Bronze' />
    {/if}
    {if $pozice == 4}
        <img src='/img/potato.gif' alt='Potato' />
    {/if}
    
    {$nick|escape}
</h3>
<table class='table'>
    <tr>
	<th>Celkové skóre</th>
	<td align='right'>{$body}</td>
    </tr><tr>
	<th>Celkové poøadí</th>
	<td align='right'>{$pozice}.</td>
    </tr><tr>
	<th>Hraje od</th>
	<td>{$added}</td>
    </tr>
</table>
<br />

<strong>Celkové umístìní:</strong><br />
<table class='table'>
    <tr>
	<th>P</th>
	<th>Nick</th>
	<th>Body</th>
    </tr>
{section name=sec1 loop=$scene}
    <tr>
	<td align='right'>
	    {if $scene[sec1]->id == $id}
	        <strong>
	    {/if}
	    {$scene[sec1]->pos}.
	    {if $scene[sec1]->id == $id}
	        </strong>
	    {/if}
        </td>
	<td>
		{if $scene[sec1]->pos == 1}
		    <img src='/img/gold-small.png' alt='Gold' />
		{/if}
		{if $scene[sec1]->pos == 2}
		    <img src='/img/silver-small.png' alt='Silver' />
		{/if}
		{if $scene[sec1]->pos == 3}
		    <img src='/img/bronze-small.png' alt='Bronze' />
		{/if}
		{if $scene[sec1]->id == $id}
		    <strong>
		{else}
		    <a href='{$scene[sec1]->nick|escape}'>
		{/if}
		{$scene[sec1]->nick|escape}
		{if $scene[sec1]->id == $id}
		    </strong>
		{else}
    		    </a>
		{/if}
	</td>
	<td align='right'>
	    {if $scene[sec1]->id == $id}
	        <strong>
	    {/if}
	    {$scene[sec1]->body}
	    {if $scene[sec1]->id == $id}
		</strong>
    	    {/if}
	</td>
    </tr>
{/section}
</table>

<br />
<strong>Skóre po mìsících:</strong><br />
<table class='table'>
    <tr>
	<th>Mìsíc a rok</th>
	<th>Body</th>
	<th>Pozice</th>
	<th></th>
    </tr>
{section name=sec1 loop=$history}
    <tr>
	<td>{$history[sec1]->name}</td>
	<td align='right'>{$history[sec1]->body}</td>
	<td align='right'>
	{if $history[sec1]->pozice == 1}
	    <img src='/img/gold-small.png' alt='Gold' />
	{/if}
	{if $history[sec1]->pozice == 2}
	    <img src='/img/silver-small.png' alt='Silver' />
	{/if}
	{if $history[sec1]->pozice == 3}
	    <img src='/img/bronze-small.png' alt='Bronze' />
	{/if}
	
	{$history[sec1]->pozice}.</td>
        <td><img src='/img/bar.gif' alt='Bar' width='{$history[sec1]->width}' height='15' /></td>
    </tr>
{/section}
</table>

<br />
<img src='/skore_graf.htm?w=sum&amp;nick={$id}&amp;interval=a' alt='Graf' />
<img src='/skore_graf.htm?w=sumMonth&amp;nick={$id}&amp;interval=a' alt='Graf' />
<br />
<img src='/skore_graf.htm?w=income&amp;nick={$id}&amp;interval=d' alt='Graf' />
<img src='/skore_graf.htm?w=income&amp;nick={$id}&amp;interval=w' alt='Graf' />
<br />
<img src='/skore_graf.htm?w=income&amp;nick={$id}&amp;interval=m' alt='Graf' />
<img src='/skore_graf.htm?w=income&amp;nick={$id}&amp;interval=y' alt='Graf' />
<br />
<small>
<a href='/rrd/score/{$id}_sum.rrd'>RRD skore</a> |
<a href='/rrd/score/{$id}_income.rrd'>RRD zisk</a>
</small>

{if $auth->perm_a}
<h3>Pøevést skóre</h3>
<form method='post' action='skore.htm'>
<input type='hidden' name='w' value='move' />
<input type='hidden' name='id' value='{$id}' />
Cílový nick: <input type='text' name='nick' />
<input type='submit' value='Pøevést' />
</form>
{/if}
