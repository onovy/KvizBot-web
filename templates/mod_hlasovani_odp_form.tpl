<form method='post' action='hlasovani.htm'>
<fieldlist>
Odpověď:
<input type='text' name='odpoved' maxlength='100' />
<input type='submit' value='Přidat' />
<input type='hidden' name='w' value='{$w}' />
<input type='hidden' name='otazka' value='{$otazka_id}' /><br />
Přidat další odpověď?: <input type='checkbox' name='next' />
</fieldlist>
</form>
