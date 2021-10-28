<h2>{$title|escape}</h2>

<p class='message'>
{$message}
</p>

{if $auth->perm_w}
<script type="text/javascript" src="{$WEB_WWW}/js/onovyPHPlib/ot2html.js"></script>
<form method='post'>
<fieldlist>
<input type='hidden' name='w' value='add' />
<table border='0'>
    <tr>
	<td>Název:</td>
	<td><input type='text' name='nazev' /></td>
    </tr><tr>
	<td>Text:</td>
	<td width='100%'>
	    <script type="text/javascript">
    		new ot2html("text","",30,10);
	    </script>
	</td>
    </tr><tr>
	<td></td>
	<td><input type='submit' value='Pøidat' /></td>
    </tr>
</table>
</fieldlist>
</form>
{/if}

{if $offset>=10}
<a href='?offset={$offset-10}'>Novìj¹í</a>
{/if}

{section name=sec1 loop=$aktuality}
<div class='aktuality'>
<h3>{$aktuality[sec1]->nazev|escape} {if $auth->perm_w}<a href='?w=del&amp;id={$aktuality[sec1]->id}' onClick="return confirm('Opravdu smazat?');">smazat</a>{/if}</h3>
<ul>
    <li><span>Autor:</span> {$aktuality[sec1]->autor|escape}</li>
    <li><span>Èas:</span> {$aktuality[sec1]->kdy|escape}</li>
</ul>
{$aktuality[sec1]->text}
</div>
{/section}

<a href='?offset={$offset+10}'>Star¹í</a>
