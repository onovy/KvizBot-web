<h2>{$title|escape}</h2>

{include file="../onovyPHPlib/templates/message.tpl"}

<h3>Editace pr�v</h3>
<form method='post' action='perms.htm'>
<input type='hidden' name='w' value='perm' />
<table class='form'>
<tr>
    <th>Nick:</th>
    <td><input type='text' name='nick' /><td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Editovat' /><td>
</tr>
</table>
</form>

<h3>Nastaven� hesla na web</h3>
<form method='post' action='perms.htm'>
<input type='hidden' name='w' value='pass' />
<table class='form'>
<tr>
    <th>Nick:</th>
    <td><input type='text' name='nick' /><td>
</tr><tr>
    <th>Heslo:</th>
    <td><input type='text' name='pass' /><td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Nastavit' /><td>
</tr>
</table>
</form>

<h3>Seznam aktu�ln�ch pr�v</h3>
<table class='table'>
<tr>
    <th>Nick</th>
    <th colspan='{$perms_count}'>Pr�va</th>
</tr>
{section name=sec1 loop=$perms}
<tr>
    {section name=sec2 loop=$perms[sec1]}
	{if $smarty.section.sec2.index==0}
	    <td>{$perms[sec1][sec2]}</td>
	{else}
	    {if $perms[sec1][sec2]!=''}
	    <td class='perm_on'>
	    {$perms[sec1][sec2]}
	    </td>
	    {else}
	    <td>
	    &nbsp;
	    </td>
	    {/if}
	{/if}
    {/section}
</tr>
{/section}
</table>

<br />
Legenda:
<table class='table'>
<tr>
    <th>L</th>
    <th>Textov� popis</th>
</tr>
{section name=sec1 loop=$perms_types}
<tr>
    <td>{$perms_types[sec1]->level}</td>
    <td>{$perms_types[sec1]->name|escape}</td>
</tr>
{/section}
</table>
