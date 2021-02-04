{extends file="layout.tpl"}
<!-- index.tpl -->

{block name=body}
<div class="container">

  <div>
{foreach $lists as $list}
  <h3>{$list.name}</h3>
  <div><a href="{$site_url}configure/{$list.url}">Configure</a>&nbsp;&nbsp;<a href="{$site_url}subscribers/{$list.url}">Subscribers<a/></div>
{/foreach}
  </div>
<hr>
<p>
{$php_self}
</p>
<br />
URI: {$uri}
<br />
listdir: {$listdir}
<br />

<pre>
{$server_settings}
</pre>
<br />

</div>
{/block}
