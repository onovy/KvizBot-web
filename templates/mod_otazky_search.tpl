<h2>FullText</h2>
Hledan� �et�zec: {$text|escape}<br>
V�sledky:
<table class='table'>
<tr>
    <th>Ot�zka</th>
    <th>Odpove�</th>
</tr>
{section name=sec1 loop=$result}
<tr>
    <td><a href='?w=id&id={$result[sec1]->id}'>{$result[sec1]->otazka}</a></td>
    <td><a href='?w=id&id={$result[sec1]->id}'>{$result[sec1]->odpoved}</a></td>
</tr>
{/section}
</table>
