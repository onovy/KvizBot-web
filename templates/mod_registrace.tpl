<h2>{$title|escape}</h2>

<p class='{$message_c}'>
{$message}
</p>

<form method='post' action='/registrace.htm'>
<fieldset>
<input type='hidden' name='w' value='hash' />
Nick: <input type='text' name='nick' />
<input type='submit' value='Zaregistrovat' />
</fieldset>
</form>
