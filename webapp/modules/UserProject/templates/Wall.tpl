{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='UserHeader'}

<div id="BreadCrumbs">
	<a href="/UserProject/">プロジェクト一覧</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{strip}
	{image_cache size='logo' class='Project' id=$project.id style_class='bordered'}
	{$action.title}
{/strip}</h1>

<div id="members" class="common_block">
	[<a id="account_list_link" href="#">メンバー...</a>]
</div>

<div>
	[<a href="/{$module.name}/Wall/{$project.id}">ウォールビュー</a>]
	[<a href="/{$module.name}/Tags/{$project.id}">フォルダビュー</a>]
</div>

<h2>ウォール</h2>

<script type="text/javascript">
{literal}
document.observe('dom:loaded', function () {
  $('account_list_link').observe('click', function() {
    $('members').innerHTML = 'Loading...';
    new Ajax.Updater('members', '/UserAccount/List');
  });
});
{/literal}
</script>

{include file='UserFooter'}

{* vim: set tabstop=4: *}
