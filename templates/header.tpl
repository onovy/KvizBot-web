{config_load file=templates.conf section="setup"}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset={$CHARSET}" />
  <meta http-equiv="Content-language" content="cs" />
  <meta http-equiv="Cache-Control" content="no-cache" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />
  <meta name="robots" content="index,follow" />
  <meta name="description" content="{#description#}" />
  <meta name="keywords" content="{#keywords#}" />
  <meta name="author" content="{#author#}" />
  <meta name="webmaster" content="{#webmaster#}" />
  <meta name="copyright" content="&copy; {$c_rok} {#copyright#}" />
  <meta name="verify-v1" content="dnF3eybjEr9Qj47OHCAgvjkI9s3XM2q0gG9j69JW0Yw=" >
  <link rel="home" href="{$WEB_WWW}/" />
  <link rel="stylesheet" type="text/css" media="screen,projection" href="/css/styl.css" />
  <title>{#title#} - {$title|escape}</title>
  {literal}
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10374250-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  </script>
  {/literal}
</head>
<body id="xkviz">
<div id="obsah">
    <h1 style='width: {if $topmenu}104{else}209{/if}px; height: {if $topmenu}59{else}118{/if}px;'>
	{if !$topmenu}
	    <a href="uvod.htm">
	{/if}
	    {#title#}
	    <span style='background: url("/img/xkviz{if $topmenu}_small{/if}.gif") top left no-repeat; width: {if $topmenu}104{else}209{/if}px; height: {if $topmenu}59{else}118{/if}px;'></span>
	{if !$topmenu}
	    </a>
	{/if}
    </h1>
