{*
プロジェクト詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='AdminHeader'}

<nav class="bread_crumbs">
  {if $account}
    <a href="/AdminAccount/">アカウント一覧</a>
    <a href="/AdminAccount/Detail/{$account.id}?pane=ProjectList">アカウント:{$account.company} {$account.name}</a>
  {else}
    <a href="/{$module.name}/">{$module.record_class|translate}一覧</a>
  {/if}
  <a href="#">{$action.title}</a>
</nav>

<h1>{$action.title}</h1>

<div class="tabs10">
  <ul id="Tabs">
    <li><a href="#DetailForm"><span>{$module.record_class|translate}詳細</span></a></li>
    <li><a href="#TagList"><span>フォルダ</span></a></li>
    {if !$account}<li><a href="#AccountList"><span>アカウント</span></a></li>{/if}
  </ul>
</div>

<div id="DetailForm" class="panel">
  {form attachable=true}
    <h2>■{$module.record_class|translate}詳細</h2>

    {include file='ErrorMessages'}

    <table class="detail">
      <tr>
        <th>{$module.record_class|translate}ID</th>
        <td>{$project.id}</td>
      </tr>
      <tr>
        <th>名前</th>
        <td>
          <input type="text" name="name" value="{$params.name}" size="40" maxlength="64">
        </td>
      </tr>
      <tr>
        <th>テーマ</th>
        <td>
          {html_options name='theme' values=$themes output=$themes selected=$params.theme}
        </td>
      </tr>
      <tr>
        <th>期間</th>
        <td>
          <input type="text" id="start_date" name="start_date" value="{$params.start_date|date_format:'Y.m.d'}" size="10" maxlength="10" class="english"> 〜
          <input type="text" id="end_date" name="end_date" value="{$params.end_date|date_format:'Y.m.d'}" size="10" maxlength="10" class="english">
        </td>
      </tr>
      <tr>
        <th>ロゴ</th>
        <td>
          <input type="file" name="logo" size="20"><br>
          {if $project.has_logo}
            <div class="common_block">
              {image_cache mode='lightbox' size='logo' pixel=240 style_class='bordered' flags='WIDTH_FIXED' pixel_full=500 flags_full='WITHOUT_SQUARE'}<br>
              {image_cache size='logo' mode='size'}
              [<a href="/{$module.name}/DeleteImage?name=logo">この画像を削除</a>]
            </div>
          {/if}
        </td>
      </tr>
      <tr>
        <th>状態</th>
        <td>
          {html_radios name='status' options=$status_options selected=$params.status}
        </td>
      </tr>
      <tr>
        <th>作成日</th>
        <td>{$project.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
      </tr>
      <tr>
        <th>更新日</th>
        <td>{$project.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" value="更新">
          <input type="button" value="この{$module.record_class|translate}を削除..." onclick="CarrotLib.confirmDelete('{$module.name}','Delete','{$module.record_class|translate}')">
        </td>
      </tr>
    </table>
  {/form}
</div>

<div id="TagList" class="panel"></div>
{if !$account}<div id="AccountList" class="panel"></div>{/if}

<script>
document.observe('dom:loaded', function () {ldelim}
  new ProtoTabs('Tabs', {ldelim}
    defaultPanel:'{$params.pane|default:'DetailForm'}',
    ajaxUrls: {ldelim}
      TagList: '/AdminTag/',
      AccountList: '/AdminAccount/ListByProject'
    {rdelim}
  {rdelim});
  new InputCalendar('start_date', {ldelim}
    lang:'ja',
    format:'yyyy.mm.dd'
  {rdelim});
  new InputCalendar('end_date', {ldelim}
    lang:'ja',
    format:'yyyy.mm.dd'
  {rdelim});
{rdelim});
</script>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
