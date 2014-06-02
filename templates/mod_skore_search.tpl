<h2>Skóre - hledání</h2>
<table class='table'>
    <tr>
	<th>Nick</td>
    </tr>
{section name=sec1 loop=$result}
    <tr>
	<td>
	    <a href='?w=info&amp;user={$result[sec1]->id}'>
		{$result[sec1]->nick|escape}
	    </a>
	</td>
    </tr>
{/section}
</table>
