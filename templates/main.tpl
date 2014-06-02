{include file="header.tpl"}

{include file="menu.tpl"}

{if !$topmenu}
    {$rpanel}
<div id="hlavni">
{else}
<div>
{/if}

{if $main_onovyPHPlib}
    {include file="../onovyPHPlib/templates/$main.tpl"}
{else}
    {include file="mod_$main.tpl"}
{/if}

</div>
<div class="cleaner">&nbsp;</div>

{include file="footer.tpl"}
