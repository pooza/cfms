{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{form method="get" onsubmit='return false' style_class='common_block'}
  <input type="text" id="key" value="{$params.key}">
  <input type="button" value="抽出" onclick="CFMSLib.updateAccountList()">
  <input type="button" value="抽出の解除" onclick="CFMSLib.initializeAccountList()">
{/form}

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
  <colgroup>
    <col width="30">
    <col width="32">
    <col width="210">
    <col width="150">
    <col width="90">
  </colgroup>
  <tr>
    <th></th>
    <th></th>
    <th>会社</th>
    <th>名前</th>
    <th>種類</th>
  </tr>
  {foreach from=$accounts item='account'}
    <tr id="account_row_{$account.id}" class="{if $params.accounts[$account.id]}show{else}hide{/if}">
      <td align="center">
        <input id="account_{$account.id}" type="checkbox" {if $params.accounts[$account.id]}checked="checked"{/if} onchange="CFMSLib.updateAccountStatus(this)">
      </td>
      <td align="center">{if $account.has_icon}{image_cache id=$account.id size='icon' pixel=32}{/if}</td>
      <td>{$account.company}</td>
      <td><a href="/{$module.name}/Detail/{$account.id}">{$account.name}</a></td>
      <td>{$account.type|translate}</td>
    </tr>
  {foreachelse}
    <tr>
      <td colspan="5" class="alert">未登録です。</td>
    </tr>
  {/foreach}
  <tr>
    <td colspan="5" style="text-align:center">
      {strip}
        <span><a href="javascript:void({if 1<$page}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page=1'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/left3.gif" width="14" height="14" alt="|&lt;"></a></span>&nbsp;
        <span><a href="javascript:void({if 1<$page}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page={$page-1}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/left1.gif" width="14" height="14" alt="&lt;"></a></span>&nbsp;
        [{$page}]&nbsp;
        <span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page={$page+1}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/right1.gif" width="14" height="14" alt="&gt;"></a></span>&nbsp;
        <span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page={$lastpage}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/right3.gif" width="14" height="14" alt="&gt;|"></a></span>
      {/strip}
    </td>
  </tr>
</table>

{* vim: set tabstop=4: *}
