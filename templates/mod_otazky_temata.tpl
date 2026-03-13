<h2>Témata</h2>

{include file="../onovyPHPlib/templates/message.tpl"}

<form method='POST'>
<input type='hidden' name='w' value='temata'>
<input type='hidden' name='w2' value='add'>
<table class='form'>
<tr>
    <td>Název:</td>
    <td><input type='text' name='nazev'></td>
</tr><tr>
    <td>Schován?:</td>
    <td><input type='checkbox' name='hide'></td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Pøidat'></td>
</tr>
</table>
</form>
<table class='table'>
<tr>
    <th>Název</th>
    <th>Schován?</th>
</tr>
{section name=sec1 loop=$temata_list}
<tr>
    <td>{$temata_list[sec1]->nazev|escape}</td>
    {if $temata_list[sec1]->hidden!=0}
         <td bgcolor='red'>ANO</td>
    {else}
        <td>ne</td>
    {/if}
</tr>
{/section}
</table>
