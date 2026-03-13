<h2>{$title|escape}</h2>

{include file="../onovyPHPlib/templates/message.tpl"}

<form method='post' action='/registrace.htm'>
<fieldset>
<input type='hidden' name='w' value='hash' />
Nick: <input type='text' name='nick' />
<input type='submit' value='Zaregistrovat' />
</fieldset>
</form>
