<form method='post' action='hlasovani.htm'>
<fieldlist>
Odpov��:
<input type='text' name='odpoved' maxlength='100' />
<input type='submit' value='P�idat' />
<input type='hidden' name='w' value='{$w}' />
<input type='hidden' name='otazka' value='{$otazka_id}' /><br />
P�idat dal�� odpov��?: <input type='checkbox' name='next' />
</fieldlist>
</form>
