{extends file="layout.tpl"}
{* subscribers.tpl *}
{block name=body}
{strip}
<div class="container">
  <h3>Subscribers</h3>
  <div class="row subhead">
    <div class="col-6"><p>List: <b>{$list}</b></p></div>
    <div class="col-6"><p><a href="{$site_url}configure/{$list}"><i class="fa fa-cogs" aria-hidden="true"></i> Configure</a></p></div>
  </div>
  <div class="row sublist">
    <div class="col-6 col-sublist">
      {* loop over sub list *}
      {foreach $subs as $sub}
      <div class="{cycle values="odd,even"} row row-grid">
        <div class="col-8" >{$sub.address}</div>
        <div class="col-4">
          <form action="{$site_url}subscribers/{$list}" method="post" >
          <input type="hidden" name="email" value="{$sub.spch}" />
          <input type="submit" name="delete" value="Remove" class="btn btn-primary btn-sm" />
          </form>
        </div>
      </div>
      {/foreach}
    </div>
    <div class="col-5 col-sublist-form">
      <form method="post" action="{$site_url}subscribers/{$list}" id="addsubscribers">
      Add subscribers:<br/>
      <textarea name="tosubscribe" rows="7" cols="30"></textarea>
      <br/>
      <input type="submit" name="submit" value="Add" class="btn btn-primary btn-sm" />
      </form>
      <br/>
    </div>
  </div>
</div>
{/strip}
{/block}
