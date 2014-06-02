<h2>FullText</h2>
Hledaný øetìzec: {$text|escape}<br>
Výsledky:
<table class='table'>
<tr>
    <th>Otázka</th>
    <th>Odpoveï</th>
</tr>
{section name=sec1 loop=$result}
<tr>
    <td><a href='?w=id&id={$result[sec1]->id}'>{$result[sec1]->otazka}</a></td>
    <td><a href='?w=id&id={$result[sec1]->id}'>{$result[sec1]->odpoved}</a></td>
</tr>
{/section}
</table>
