<h2>Hlasy</h2>

<table class='table'>
<tr>
    <th>Odpověď</th>
    <th>Nick</th>
    <th>IP</th>
    <th>Reverz</th>
</tr>
{section name=sec1 loop=$hlasy}
<tr>
    <td>{$hlasy[sec1]->odpoved|escape}</td>
    <td><a href='skore.htm?w=info&amp;user={$hlasy[sec1]->nick_id}'>{$hlasy[sec1]->nick}</a></td>
    <td>{$hlasy[sec1]->ip|escape}</td>
    <td>{$hlasy[sec1]->ip_rev|escape}</td>
</tr>
{/section}
</table>