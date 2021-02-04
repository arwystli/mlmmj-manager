{extends file="layout.tpl"}
{* configure.tpl *}
{block name=body}
{strip}
<div class="container">
  <h3>Configuration</h3>
  <div class="row confhead">
    <div class="col-6"><p>List: <b>{$action}</b></p></div>
    <div class="col-6"><p><a href="{$site_url}subscribers/{$action}"><i class="fa fa-list" aria-hidden="true"></i> Show Subscribers</a></p></div>
  </div>

  <form method="post" action="{$site_url}configure/save">
    <input type="hidden" name="list" value="{$list}">
    {foreach $rows as $row}
      <div class="{cycle values="odd,even"} row-grid" >
        {$row}
      </div>
    {/foreach}
    <input type="submit" name="submit" value="Save" class="btn btn-primary btn-sm" />
  </form>

</div>
{/strip}
{/block}
