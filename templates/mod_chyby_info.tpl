<h2>{$title|escape}</h2>

<p>
<a href='?w=list&amp;filter=open'>Zpìt na seznam chyb</a>
</p>

{if $message}
<p class='{$message_c}'>
    {$message}
</p>
{/if}

<table class='table'>
<tr>
    <th>ID</th>
    <td>
    {if $auth->perm_o}
	<a href='otazky.htm?w=id&amp;id={$info->cislo|escape}&amp;comment=Oprava%20podle%20chyby%20ID:%20{$info->id}'>
    {/if}
	    {$info->cislo|escape}
    {if $auth->perm_o}
	</a>
    {/if}
    </td>
</tr>
{if $auth->perm_o}
<tr>
    <th>Otázka</th>
    <td>{$info->otazka|escape}</td>
</tr>
<tr>
    <th>Odpovìï</th>
    <td>{$info->odpoved|escape}</td>
</tr>
{/if}
<tr>
    <th>Text</th>
    <td>{$info->text}</td>
</tr>
<tr>
    <th>Odkaz na dùkaz</th>
    <td><a href='{$info->link|escape}'>{$info->link|escape}</a></td>
</tr>
<tr>
    <th>Stav</th>
    <td>{$info->stav|escape}</td>
</tr>
<tr>
    <th>Autor</th>
    <td>
	{if $info->nick_old}
	    <a href='http://xchat.cz/{$info->nick_old|escape}'>
		<strike>{$info->nick_old|escape}</strike>
	    </a>
	{else}
	    <a href='skore.htm?w=info&amp;user={$info->nick_id}'>
		{$info->nick|escape}
	    </a>
	{/if}
    </td>    
</tr>
{if $auth->perm_c}
<tr>
    <th>IP</th>
    <td>
        {$info->ip|escape}</a></td>
</tr>
{/if}
<tr>
    <th>Pøidáno</th>
    <td>{$info->pridano|escape}</td>
</tr>
{if $info->o_stav!='open'}
<tr>
    <th>
    {if $info->o_stav=='close'}
	Opraveno
    {else}
	Zamítnuto
    {/if}
    </th>
    <td>{$info->uzavreno|escape}</td>
</tr>
{/if}
{if $info->comment}
<tr>
    <th>Komentáø</th>
    <td>{$info->comment|escape}</td>
</tr>
{/if}
</table>

{section name=sec1 loop=$refer}
{if $smarty.section.sec1.first}
    <h3>Související chyby</h3>
    <table class='table'>
    <tr>
	<th>Stav</th>
        <th>Pøidáno</th>
        <th>Uzavøeno</th>
        <th>Nick</th>
{if $auth->perm_c}
        <th>IP</th>
{/if}
        <th>zobrazit</th>
    </tr>
{/if}
<tr>
    <td>{$refer[sec1]->stav|escape}</td>
    <td>{$refer[sec1]->pridano}</td>
    <td>{$refer[sec1]->uzavreno}</td>
    <td>
	{if $info->nick_old}
	    <a href='http://xchat.cz/{$info->nick_old|escape}'>
		<strike>{$info->nick_old|escape}</strike>
	    </a>
	{else}
	    <a href='skore.htm?w=info&amp;user={$info->nick_id}'>
		{$info->nick|escape}
	    </a>
	{/if}
    </td>
{if $auth->perm_c}
    <td>{$refer[sec1]->ip|escape}</td>
{/if}
    <td><a href='?w=info&amp;chyba={$refer[sec1]->id}'>zobrazit</a></td>
</tr>

{if $smarty.section.sec1.last}
    </table>
{/if}
{/section}


{if $info->o_stav=='open' && $auth->perm_c}
<h3>Zmìnit stav na</h3>
<form method='post'>
<input type='hidden' name='w' value='set_stav' />
<input type='hidden' name='chyba' value='{$chyba_id}' />
<table class='form'>
<tr>
    <td><input type='radio' name='stav' value='open'{if $info->o_stav=='open'} checked="checked"{/if}></td>
    <td>Otevøená </td>
</tr><tr>
    <td><input type='radio' name='stav' value='close'{if $info->o_stav=='close'} checked="checked"{/if}></td>
    <td>Opravená</td>
</tr><tr>
    <td><input type='radio' name='stav' value='unconfirmed'{if $info->o_stav=='unconfirmed'} checked="checked"{/if}></td>
    <td>Zamítnutá </td>
</tr><tr>
    <td></td>
    <td>Komentáø: <textarea name='comment'>{$info->comment|escape}</textarea></td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Nastavit' /></td>
</tr>
</table>
</form>
{/if}