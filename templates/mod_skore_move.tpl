<h2>Pøevedení skóre</h2>
<font color='red'>{$error|escape}</font>

<p>
    Z nicku: {$nick|escape}<br />
    Na nick: {$nick_to|escape}
</p>

{if $error==''}
<form method='post' action='skore.htm'>
    <input type='hidden' name='w' value='move' />
    <input type='hidden' name='confirm' value='1' />
    <input type='hidden' name='id' value='{$id}' />
    <input type='hidden' name='nick' value='{$nick_to}' />
    <input type='submit' value='Potvrdit' />
</form>

{/if}