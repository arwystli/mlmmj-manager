{extends file="layout.tpl"}
{block name=body}
<div class="container">
  <h3>Mailing lists</h3>
  <div class="row">
    <div class="col-12 col-ml-list">
      {* loop over ml list *}
      {foreach $lists as $list}
      <div class="{cycle values="odd,even"} row row-grid">
        <div class="col-5"><b>{$list.name}</b></div>
        <div class="col-3 confbtn"><a href="{$site_url}configure/{$list.url}"><button type="button" class="btn btn-primary btn-sm">Configure</button></a></div>
        <div class="col-3 subbtn"><a href="{$site_url}subscribers/{$list.url}"><button type="button" class="btn btn-secondary btn-sm">Subscribers</button></a></div>
      </div>
      {/foreach}
    </div>
  </div>
</div>
{/block}
