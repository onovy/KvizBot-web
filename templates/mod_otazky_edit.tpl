<h2>�prava ot�zky</h2>

{$message}
<form method='POST'>
<input type='hidden' name='w' value='edit'>
<input type='hidden' name='id' value='{$id}'>
<table border='0'>
<tr>
    <td>Schv�len� ot�zka:</td>
    <td>{$otazka_s}
</tr><tr>
    <td>Ot�zka:</td><td><input type='text' name='otazka' maxlength='100' size='70' value='{$change_otazka|escape}'></td>
</tr><tr>
    <td>Schv�len� odpove�:</td>
    <td>{$odpoved_s}
</tr><tr>
    <td>Odpove�:</td><td><input type='text' name='odpoved' maxlength='100' size='70' value='{$change_odpoved|escape}'></td>
</tr><tr>
    <td>Schv�len� t�ma:</td>
    <td>{$tema_nazev|escape}
</tr><tr>
    <td>T�ma:</td>
    <td>
	<select name='tema'>
	    <option value='0'>- vyberte -</option>
	    <option value='{$tema}'>{$tema_nazev|escape}</option>
	    <option value='0'>- vsechna temata -</option>
	{section name=sec1 loop=$temata}
	    <option value='{$temata[sec1]->id}'{if $temata[sec1]->id==$tema} selected{else}{if $temata[sec1]->id==$change_tema} selected{/if}{/if}>{$temata[sec1]->nazev|escape}</option>
	{/section}
	</select>
    </td>
</tr><tr>
    <td>Hra:</td>
    <td>
	{if $game==1}
	    Xchat
	{elseif $game==2}
	    IRC
	{elseif $game==3}
	    Xchat + IRC
	{else}
	    Deaktivov�no
	{/if}
    </td>
</tr><tr>
    <td>Pozn�mka:</td>
    <td><input type='text' name='comment' value='{$comment|escape}'>
{if $auth->perm_a}
</tr><tr>
    <td>Schv�len�:</td>
    <td>
	<select name='schvaleni'>
	    <option value='0'>- nikdo -</option>
	{section name=sec1 loop=$schvaleni}
	    <option value='{$schvaleni[sec1]->id}'{if $schvaleni[sec1]->id==$owner} selected="selected"{/if}>{$schvaleni[sec1]->nick|escape}</option>
	{/section}
	</select>
    </td>
{/if}
</tr><tr>
    <td></td><td><input type='submit' value='Upravit'></td>
</tr>
</table>
</form>

<hr />

<h3>Pravidla</h3>
{$pravidla}
