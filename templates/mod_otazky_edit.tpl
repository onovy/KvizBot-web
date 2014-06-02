<h2>Úprava otázky</h2>

{$message}
<form method='POST'>
<input type='hidden' name='w' value='edit'>
<input type='hidden' name='id' value='{$id}'>
<table border='0'>
<tr>
    <td>Schválená otázka:</td>
    <td>{$otazka_s}
</tr><tr>
    <td>Otázka:</td><td><input type='text' name='otazka' maxlength='100' size='70' value='{$change_otazka|escape}'></td>
</tr><tr>
    <td>Schválená odpoveï:</td>
    <td>{$odpoved_s}
</tr><tr>
    <td>Odpoveï:</td><td><input type='text' name='odpoved' maxlength='100' size='70' value='{$change_odpoved|escape}'></td>
</tr><tr>
    <td>Schválené téma:</td>
    <td>{$tema_nazev|escape}
</tr><tr>
    <td>Téma:</td>
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
	    Deaktivováno
	{/if}
    </td>
</tr><tr>
    <td>Poznámka:</td>
    <td><input type='text' name='comment' value='{$comment|escape}'>
{if $auth->perm_a}
</tr><tr>
    <td>Schválení:</td>
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
