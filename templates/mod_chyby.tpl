<h2>{$title|escape}</h2>

<p>
    <a href='?w=list&amp;filter=open'>Seznam nahlá¹ených chyb</a>
</p>
<p>
    <a href='?w=list&amp;filter=open&owner=me'>Seznam mnou nahlá¹ených chyb</a>
</p>

<p class='message'>
{$message}
</p>
<p>
Následujícím formuláøem mu¾ete oznámit chybu v otázce. Pøeètìte si prosím
nejdøív informace napsané ní¾e.
</p>

<form method='post' action='chyby.htm'>
<input type='hidden' name='w' value='add' />
<table class='form'>
<tr>
    <td>Èíslo otázky:</td>
    <td><input type='text' name='cislo' maxlength='10' /></td>
</tr>
<tr>
    <td>Odkaz na dùkaz:</td>
    <td><input type='text' name='link' maxlength='200' /></td>
</tr>
<tr>
    <td>Komentáø&nbsp;k&nbsp;chybì:</td>
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
	Pokud nezadáte èíslo otázky, bude chyba vyøizována s nejmen¹í
	dùle¾itostí a v pøípadì nemo¾nosti dohledání otázky nebude vyøízena.
	Pokud nezadáte odkaz na dùkaz a nebude se jednat o pøeklep, NEBUDE
	stí¾nost vyøízena. Za relevantní odkaz se pova¾uje èlánek z:
	</p>
	<ul>
	    <li><a href='http://cs.wikipedia.org/'>http://cs.wikipedia.org/</a></li>
	    <li><a href='http://en.wikipedia.org/'>http://en.wikipedia.org/</a></li>
	    <li><a href='http://encarta.msn.com/'>http://encarta.msn.com/</a></li>
	    <li><a href='http://www.cojeco.cz/'>http://www.cojeco.cz/</a></li>
	    <li><a href='http://encyclopedia.jrank.org/'>http://encyclopedia.jrank.org/</a></li>
	    <li><a href='http://www.cj.cz/'>http://www.cj.cz/</a> -- pravidla èeského pravopisu</li>
	    <li><a href='http://www.slovnik.cz/'>http://www.slovnik.cz/</a> -- pøeklad cizích slov</li>
	</ul>
	<p>
	Pokud bude udán jiný odkaz, NEBUDE chyba opravena.
	</p>
    </td>
</tr>
</table>
</form>
