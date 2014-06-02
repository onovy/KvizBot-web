<h2>{$title|escape}</h2>

<h3>Pravidla a licence</h3>
<a href='pravidla_otazky.htm'>Pravidla</a>, kter� mus� spl�ovat v�echny ot�zky.<br />
<a href='licence-otazek.htm'>Licence</a>, pod kterou jsou v�echny ot�zky p�id�v�ny.

{if $auth->perm_o}
<h3>Editace</h3>
<a href='?w=add'>P�idat ot�zku</a>
<table border=0>
<form method='get'>
<input type='hidden' name='w' value='id' />
<tr>
    <td>ID:</td>
    <td><input type='text' name='id'></td>
    <td><input type='submit' value='Naj�t'></td>
</tr>
</form>


<form method='get'>
<input type='hidden' name='w' value='search' />
<tr>
    <td>FullText:</td>
    <td><input type='text' name='text'></td>
    <td><input type='submit' value='Naj�t'></td>
</tr>
</form>

</table>

{if $auth->perm_a}
<br />
<strong>Deaktivovat ot�zku:</strong><br />
{$mazani_message}
<table>
<form method='post'>
<input type='hidden' name='w' value='del' />
<tr>
    <td>ID:</td>
    <td><input type='text' name='id'></td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Deaktivovat'></td>
</tr>
</form>
</table>
{/if}

{/if}


{if $auth->id!=0}
<h3>Schv�len�</h3>
{$schvaleni_message}
<form method='get'>
<input type='hidden' name='w' value='schvaleni' />
<table class='table'>
<tr>
    <th></th>
    <th>ID</th>
    <th>Ot�zka</th>
    <th>Odpov��</th>
    <th>T�ma</th>
    <th>U�ivatel</th>
    <th>Koment��</th>
</tr>
{section name=sec1 loop=$schvaleni}
    <tr>
	<td><input type='checkbox' name='{$schvaleni[sec1]->id}'></td>
	<td><a href='otazky.htm?w=id&amp;id={$schvaleni[sec1]->id}'>{$schvaleni[sec1]->id}</td>
	<td>{$schvaleni[sec1]->otazka}</td>
	<td>{$schvaleni[sec1]->odpoved}</td>
	<td>{$schvaleni[sec1]->tema}</td>
	<td><a href='http://xchat.cz/{$schvaleni[sec1]->user|escape}'>{$schvaleni[sec1]->user|escape}</a></td>
	<td>{$schvaleni[sec1]->comment|escape}</td>
    </tr>
{/section}
</table>
<input type='submit' value='Schv�lit' />
</form>
{/if}

<h3>Ozn�men� chyby</h3>
<a href='chyby.htm'>Ozn�mit</a> chybu v ot�zce.

{if $auth->id!=0}
<h3>T�mata</h3>
<a href='?w=list'>Proch�zet ot�zky podle t�mat</a><br>
{if $auth->perm_a}
<a href='?w=temata'>Editovat t�mata</a><br>
{/if}
{/if}

<h3>Statistiky</h3>
<a href='?w=stats'>Zobrazit statistiky</a>
