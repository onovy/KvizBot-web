<h2>{$title|escape}</h2>

{include file="../onovyPHPlib/templates/message.tpl"}

{if $auth->perm_w|default:false}
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
<h3>{$aktuality[sec1]->nazev|escape} {if $auth->perm_w|default:false}<form method='post' style='display:inline' onsubmit="return confirm('Opravdu smazat?');"><input type='hidden' name='w' value='del' /><input type='hidden' name='id' value='{$aktuality[sec1]->id}' /><button type='submit'>smazat</button></form>{/if}</h3>
<ul>
    <li><span>Autor:</span> {$aktuality[sec1]->autor|escape}</li>
    <li><span>Èas:</span> {$aktuality[sec1]->kdy|escape}</li>
</ul>
{$aktuality[sec1]->text}
</div>
{/section}

<a href='?offset={$offset+10}'>Star¹í</a>
