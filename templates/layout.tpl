<!doctype html>
<html>
  <head>
    <title>mlmmj manager</title>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="mlmmj manager">
    <link rel="stylesheet" href="{$site_url}css/fontawesome/all.min.css">
    <link rel="stylesheet" href="{$site_url}css/bootswatch/cerulean/bootstrap.min.css">
    <link rel="stylesheet" href="{$site_url}css/all.min.css">
  </head>

  <body>
    <div id="page">
      {include "header.tpl"}
      <div class="container">
        <div >{$msg}</div>
        <div class="row">
        {* body block *}
        {block name=body}{/block}
        {* /body block *}
        </div>
        {include "footer.tpl"}
      </div>
      <script src="{$site_url}js/bootstrap/bootstrap.bundle.min.js" ></script>
    </div>
{include "devel.tpl"}

  </body>
</html>
