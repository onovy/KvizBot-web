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
    Pamatujte na to, ¾e tohle je pouze náhled, pro ulo¾ení stisknìte tlaèítko
    Ulo¾it ve spodní èásti tohoto formuláøe
</p>
<br /><br />
{/if}
{if $message!=''}<p>{$message}</p>{/if}
<form method='post'>
Text:<br />
{literal}
	<script type="text/javascript">
    	    new ot2html("txt","{/literal}{$txt|escape:"javascript"}{literal}",50,20);
	</script>
{/literal}

<input type='submit' value='Ulo¾it' name='upravit' />
<input type='submit' value='Náhled' name='nahled' />

</form>