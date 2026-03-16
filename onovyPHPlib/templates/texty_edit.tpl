<script type="text/javascript" src="{$WEB_WWW}/onovyPHPlib/js/ot2html.js"></script>
{if $title!=''}
<h2>{$title|escape} - editace</h2>
{/if}
{if $nahled!=''}
<h3>Náhled</h3>
<div class='nahled'>
{$nahled}
</div>
<br /><br />
<p class='error'>
    Pamatujte na to, že tohle je pouze náhled, pro uložení stiskněte tlačítko
    Uložit ve spodní části tohoto formuláře
</p>
<br /><br />
{/if}
{include file="message.tpl"}
<form method='post'>
Text:<br />
{literal}
	<script type="text/javascript">
    	    new ot2html("txt","{/literal}{$txt|escape:"javascript"}{literal}",50,20);
	</script>
{/literal}

<input type='submit' value='Uložit' name='upravit' />
<input type='submit' value='Náhled' name='nahled' />

</form>