<h2>{$title|escape}</h2>

{include file="../onovyPHPlib/templates/message.tpl"}

<p>
<strong>{$nick|escape}</strong>
</p>

<h3>Aktuální práva</h3>
<table class='table'>
<tr>
    <th>L</th>
    <th>Název</th>
    <th></th>
</tr>
{section name=sec1 loop=$perms}
<tr>
    <td>{$perms[sec1]->letter}</td>
    <td>{$perms[sec1]->name|escape}</td>
    <td><a href='?idn={$idn}&amp;w=perm&amp;w2=del_perm&amp;perm_id={$perms[sec1]->id}' onClick="return confirm('Opravdu odebrat?');">Odebrat</a></td>
</tr>
{/section}
</table>

<h3>Pøidání práva</h3>
<form method='post' action='perms.htm'>
<input type='hidden' name='w' value='perm' />
<input type='hidden' name='w2' value='add_perm' />
<input type='hidden' name='idn' value='{$idn}' />
<table class='form'>
<tr>
    <th>Právo:</th>
    <td>
	<select name='perm'>
{section name=sec1 loop=$perm_list}
	    <option value='{$perm_list[sec1]->perm}'>{$perm_list[sec1]->name}</option>
{/section}
	</select>
    </td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Pøidat' /></td>
</tr>
</table>
</form>
