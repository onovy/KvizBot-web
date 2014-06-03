{if $topmenu}

{if $auth->id!=0}
<span id="topmenu_login">
    <strong>Pøihlá¹en:</strong>
	<a href='/topmenu/skore.htm?w=info&amp;user={$auth->id}'>
	{$auth->uname|escape}
	</a>
</span>
{/if}

<div id='topmenu_div'>
<ul id='topmenu'>
    <li {if $menu=="aktuality"}class="tp_active"{/if}><a href='/topmenu/aktuality.htm'>AKTUALITY</a></li>
    <li {if $menu=="skore"}class="tp_active"{/if}><a href='/topmenu/skore.htm'>SKÓRE</a></li>
    <li {if $menu=="pravidla"}class="tp_active"{/if}><a href='/topmenu/pravidla.htm'>PRAVIDLA</a></li>
{if $auth->id!=0}
    <li {if $menu=="chyby"}class="tp_active"{/if}><a href='/topmenu/chyby.htm'>CHYBY</a></li>
{/if}
    <li {if $menu=="hlasovani"}class="tp_active"{/if}><a href='/topmenu/hlasovani.htm'>HLASOVÁNÍ</a></li>
{if $auth->id==0}
    <li {if $menu=="registrace"}class="tp_active"{/if}><a href='/topmenu/registrace.htm'>REGISTRACE</a></li>
    <li {if $menu=="login"}class="tp_active"{/if}><a href='/login.htm?topmenu=1'>PØIHLÁSIT SE</a></li>
{else}
    <li><a href='/logout.htm?topmenu=1'>ODHLÁSIT</a></li>
{/if}
</ul>
</div>


{else}

<div id="menu_div">
<ul id="menu">
    <li><a href='uvod.htm' {if $menu=="uvod"}class="active"{/if}>ÚVOD</a></li>
    <li><a href='aktuality.htm' {if $menu=="aktuality"}class="active"{/if}>AKTUALITY</a></li>
    <li><a href='skore.htm' {if $menu=="skore"}class="active"{/if}>SKÓRE</a></li>
    <li><a href='online.htm' {if $menu=="online"}class="active"{/if}>ONLINE</a></li>
    <li><a href='spravci.htm' {if $menu=="spravci"}class="active"{/if}>SPRÁVCI</a></li>
    <li><a href='otazky.htm' {if $menu=="otazky"}class="active"{/if}>OTÁZKY</a></li>
{if $auth->id!=0}
    <li><a href='chyby.htm' {if $menu=="chyby"}class="active"{/if}>CHYBY</a></li>
{/if}
    <li><a href='hlasovani.htm' {if $menu=="hlasovani"}class="active"{/if}>HLASOVÁNÍ</a></li>
{if $auth->id!=0}
    {if $auth->perm_p}
    <li><a href='perms.htm' {if $menu=="perms"}class="active"{/if}>PRÁVA</a></li>
    {/if}
{/if}
{if $auth->id==0}
    <li>
    <a href='registrace.htm' {if $menu=="registrace"}class="active"{/if}>REGISTRACE</a>
    </li>
    <li>
    <a href='login.htm' {if $menu=="login"}class="active"{/if}>PØIHLÁSIT SE</a>
    </li>
{else}
    <li>
    <a href='logout.htm'>ODHLÁSIT</a>
    </li>
{/if}
</ul>

{if $auth->id!=0}
<div id="login">
    <b>Pøihlá¹en:</b><br />
    {$auth->uname|escape}
</div>
{/if}

</div>

{/if}