<h2>T�mata</h2>
<form method='POST'>
<input type='hidden' name='w' value='temata'>
<input type='hidden' name='w2' value='add'>
<table class='form'>
<tr>
    <td>N�zev:</td>
    <td><input type='text' name='nazev'></td>
</tr><tr>
    <td>Schov�n?:</td>
    <td><input type='checkbox' name='hide'></td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='P�idat'></td>
</tr>
</table>
</form>
<table class='table'>
<tr>
    <th>N�zev</th>
    <th>Schov�n?</th>
</tr>
{section name=sec1 loop=$temata_list}
<tr>
    <td>{$temata_list[sec1]->nazev|escape}</td>
    <td{if $temata_list[sec1]->hidden!=0} bgcolor='red'{/if}>
    {$temata_list[sec1]->hidden}</td>
</tr>
{/section}
</table>
