<h2>{$title|escape}</h2>

<p class='{$message_c}'>
{$message}
</p>

Nastaven� hesla pro p�ihl�en� do webu:
<form method='post' action='/registrace.htm'>
<fieldset>
<input type='hidden' name='w' value='password2' />
<input type='hidden' name='hash' value='{$hash}' />
Heslo: <input type='password' name='pass' />
Heslo znovu: <input type='password' name='pass2' />
<br />
<input type='submit' value='Dokon�it registraci' />
</fieldset>
</form>
