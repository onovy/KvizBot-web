<h2>P�id�n� ot�zky</h2>

{$message}
<form method='POST'>
<input type='hidden' name='w' value='add2'>
<table border='0'>
<tr>
    <td>Ot�zka:</td><td><input type='text' name='otazka' maxlength='100' size='70' value='{$otazka}'></td>
</tr><tr>
    <td>Odpove�:</td><td><input type='text' name='odpoved' maxlength='100' size='70' value='{$odpoved}'></td>
</tr><tr>
    <td>T�ma:</td>
    <td>
	<select name='tema'>
	    <option value='0'>- vyberte -</option>
	{section name=sec1 loop=$temata}
	    <option value='{$temata[sec1]->id}'{if $tema==$temata[sec1]->id} selected{/if}>{$temata[sec1]->nazev|escape}</option>
	{/section}
	</select>
    </td>
{if $auth->perm_a}
</tr><tr>
    <td>Schv�len�:</td>
    <td>
	<select name='schvaleni'>
	    <option value='0'>- nikdo -</option>
	{section name=sec1 loop=$schvaleni}
	    <option value='{$schvaleni[sec1]->id}'>{$schvaleni[sec1]->nick|escape}</option>
	{/section}
	</select>
    </td>
{/if}
</tr><tr>
    <td></td><td><input type='submit' value='P�idat'></td>
</tr><tr>
    <td colspan=2>P�ed p�id�n�m ot�zky do Kv�zu si pros�m p�e�t�te <a href='licence-otazek.htm' target='_blank'>licencov�n�</a></td>
</tr>
</table>
</form>

<hr />

<h3>Pravidla</h3>
{$pravidla}
