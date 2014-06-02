<div id="ostatni">

TOP mìsíèního skóre:<br />
<table>
    <tr>
	<th>P</th>
	<th>Nick</th>
	<th>Body</th>
    </tr>
{section name=sec1 loop=$rpanel_top_month}
    <tr>
	<td align='right'>{$smarty.section.sec1.index+1}.</td>
	<td>
	    <a href='{$rpanel_top_month[sec1]->rnick|escape}' title='{$rpanel_top_month[sec1]->rnick|escape}'>{$rpanel_top_month[sec1]->nick|escape}</a>{if $rpanel_top_month[sec1]->nick!=$rpanel_top_month[sec1]->rnick}...{/if}
	</td>
	<td align='right'>{$rpanel_top_month[sec1]->body}</td>
    </tr>
{/section}
</table>
<br />
TOP celkového skóre:<br />
<table>
    <tr>
	<th>P</th>
	<th>Nick</th>
	<th>Body</th>
    </tr>
{section name=sec1 loop=$rpanel_top_all}
    <tr>
	<td align='right'>{$smarty.section.sec1.index+1}.</td>
	<td>
	    <a href='{$rpanel_top_all[sec1]->rnick|escape}' title='{$rpanel_top_all[sec1]->rnick|escape}'>{$rpanel_top_all[sec1]->nick|escape}</a>{if $rpanel_top_all[sec1]->nick!=$rpanel_top_all[sec1]->rnick}...{/if}
	</td>
	<td align='right'>{$rpanel_top_all[sec1]->body}</td>
    </tr>
{/section}
</table>

</div>
