<h2>{$title|escape}</h2>

<form method='get' name='f'>
<input type='hidden' name='w' value='list' />
<table class='form'>
<tr>
    <td>Tøídìní:</td>
    <td>
	<select name='order' onChange='document.f.submit();'>
	    <option value='pridano'{if $order=='pridano'} selected{/if}>Datum pøidání</option>
	    <option value='cislo'{if $order=='cislo'} selected{/if}>ID</option>
	    <option value='nick'{if $order=='nick'} selected{/if}>Nick</option>
	</select>
	<select name='desc' onChange='document.f.submit();'>
	    <option value=''{if $desc==''} selected{/if}>Vzestupnì</option>
	    <option value='1'{if $desc=='1'} selected="selected"{/if}>Sestupnì</option>
	</select>
    </td>
</tr><tr>
    <td>Stav:</td>
    <td>
	<select name='filter' onChange='document.f.submit();'>
            <option value=''{if $filter==''} selected{/if}>V¹echny</option>
	    <option value='open'{if $filter=='open'} selected="selected"{/if}>Otevøené</option>
	    <option value='close'{if $filter=='close'} selected="selected"{/if}>Opravené</option>
	    <option value='unconfirmed'{if $filter=='unconfirmed'} selected="selected"{/if}>Zamítnuté</option>
	</select>
    </td>
</tr><tr>
    <td>Autor:</td>
    <td>
	<select name='owner' onChange='document.f.submit();'>
            <option value=''{if $owner==''} selected{/if}>Kdokoliv</option>
	    <option value='me'{if $owner=='me'} selected="selected"{/if}>Pouze já</option>
	</select>
    </td>
</tr><tr>
    <td></td>
    <td><input type='submit' value='Zobrazit' /></td>
</tr>
</table>
</form>

<table class='table'>
<tr>
    <th>ID</th>
    <th>Datum pøidání</th>
    <th>Autor</th>
</tr>
{section name=sec1 loop=$chyby}
<tr>
    <td align='right'><a href='?w=info&amp;chyba={$chyby[sec1]->id|escape}'>{$chyby[sec1]->cislo|escape}</a></td>
    <td>{$chyby[sec1]->pridano|escape}</td>
    <td>
	{if $chyby[sec1]->nick_old}
	    <a href='http://xchat.cz/{$chyby[sec1]->nick_old|escape}'>
		<strike>{$chyby[sec1]->nick_old|escape}</strike>
	    </a>
	{else}
	    <a href='skore.htm?w=info&amp;user={$chyby[sec1]->nick_id}'>
		{$chyby[sec1]->nick|escape}
	    </a>
	{/if}
    </td>
</tr>
{/section}
</table>
