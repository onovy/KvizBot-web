<h2>{$title|escape}</h2>

<p>
    <a href='?w=list&amp;filter=open'>Seznam nahlášených chyb</a>
</p>
<p>
    <a href='?w=list&amp;filter=open&owner=me'>Seznam mnou nahlášených chyb</a>
</p>

{include file="../onovyPHPlib/templates/message.tpl"}

<p>
Následujícím formulářem mužete oznámit chybu v otázce. Přečtěte si prosím
nejdřív informace napsané níže.
</p>

<form method='post' action='chyby.htm'>
<input type='hidden' name='w' value='add' />
<table class='form'>
<tr>
    <td>Číslo otázky:</td>
    <td><input type='text' name='cislo' maxlength='10' /></td>
</tr>
<tr>
    <td>Odkaz na důkaz:</td>
    <td><input type='text' name='link' maxlength='200' /></td>
</tr>
<tr>
    <td>Komentář&nbsp;k&nbsp;chybě:</td>
    <td><textarea name='text' cols='{if $topmenu}20{else}40{/if}' rows='10'></textarea></td>
</tr>
<tr>
    <td></td>
    <td><input type='submit' value='Odeslat' /></td>
</tr>
<tr>
    <td>!POZOR!</td>
    <td>
	<p>
	Pokud nezadáte číslo otázky, bude chyba vyřizována s nejmenší
	důležitostí a v případě nemožnosti dohledání otázky nebude vyřízena.
	Pokud nezadáte odkaz na důkaz a nebude se jednat o překlep, NEBUDE
	stížnost vyřízena. Za relevantní odkaz se považuje článek z:
	</p>
	<ul>
	    <li><a href='http://cs.wikipedia.org/'>http://cs.wikipedia.org/</a></li>
	    <li><a href='http://en.wikipedia.org/'>http://en.wikipedia.org/</a></li>
	    <li><a href='http://encarta.msn.com/'>http://encarta.msn.com/</a></li>
	    <li><a href='http://www.cojeco.cz/'>http://www.cojeco.cz/</a></li>
	    <li><a href='http://encyclopedia.jrank.org/'>http://encyclopedia.jrank.org/</a></li>
	    <li><a href='http://www.cj.cz/'>http://www.cj.cz/</a> -- pravidla českého pravopisu</li>
	    <li><a href='http://www.slovnik.cz/'>http://www.slovnik.cz/</a> -- překlad cizích slov</li>
	</ul>
	<p>
	Pokud bude udán jiný odkaz, NEBUDE chyba opravena.
	</p>
    </td>
</tr>
</table>
</form>
