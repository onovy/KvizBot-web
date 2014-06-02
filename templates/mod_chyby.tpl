<h2>{$title|escape}</h2>

<p>
    <a href='?w=list&amp;filter=open'>Seznam nahl�en�ch chyb</a>
</p>
<p>
    <a href='?w=list&amp;filter=open&owner=me'>Seznam mnou nahl�en�ch chyb</a>
</p>

<p class='message'>
{$message}
</p>
<p>
N�sleduj�c�m formul��em mu�ete ozn�mit chybu v ot�zce. P�e�t�te si pros�m
nejd��v informace napsan� n�e.
</p>

<form method='post' action='chyby.htm'>
<input type='hidden' name='w' value='add' />
<table class='form'>
<tr>
    <td>��slo ot�zky:</td>
    <td><input type='text' name='cislo' maxlength='10' /></td>
</tr>
<tr>
    <td>Odkaz na d�kaz:</td>
    <td><input type='text' name='link' maxlength='200' /></td>
</tr>
<tr>
    <td>Koment��&nbsp;k&nbsp;chyb�:</td>
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
	Pokud nezad�te ��slo ot�zky, bude chyba vy�izov�na s nejmen��
	d�le�itost� a v p��pad� nemo�nosti dohled�n� ot�zky nebude vy��zena.
	Pokud nezad�te odkaz na d�kaz a nebude se jednat o p�eklep, NEBUDE
	st�nost vy��zena. Za relevantn� odkaz se pova�uje �l�nek z:
	</p>
	<ul>
	    <li><a href='http://cs.wikipedia.org/'>http://cs.wikipedia.org/</a></li>
	    <li><a href='http://en.wikipedia.org/'>http://en.wikipedia.org/</a></li>
	    <li><a href='http://encarta.msn.com/'>http://encarta.msn.com/</a></li>
	    <li><a href='http://www.cojeco.cz/'>http://www.cojeco.cz/</a></li>
	    <li><a href='http://encyclopedia.jrank.org/'>http://encyclopedia.jrank.org/</a></li>
	    <li><a href='http://www.cj.cz/'>http://www.cj.cz/</a> -- pravidla �esk�ho pravopisu</li>
	    <li><a href='http://www.slovnik.cz/'>http://www.slovnik.cz/</a> -- p�eklad ciz�ch slov</li>
	</ul>
	<p>
	Pokud bude ud�n jin� odkaz, NEBUDE chyba opravena.
	</p>
    </td>
</tr>
</table>
</form>
