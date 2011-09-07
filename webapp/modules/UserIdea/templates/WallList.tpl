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
	Loading...
</div>

<div>
	[<a href="/UserProject/Wall/{$project.id}">ウォールビュー</a>]
	[<a href="/UserProject/Tags/{$project.id}">フォルダビュー</a>]
</div>

<h2>ウォール</h2>
<a href="/UserIdea/Create">新しいファイルを登録...</a>

{foreach from=$ideas item='idea'}
	<div class="idea common_block">
		{if $idea.delete_date}
			<p class="alert">削除済みです。</p>
		{else}
			<h2><a href="/UserIdea/Detail/{$idea.id}">{$idea.name}</a></h2>
			
			{if $idea.is_image}
				<div>
					{image_cache class='Idea' id=$idea.id size='attachment' pixel=64}
				</div>
			{/if}
			<div>{$idea.body|truncate:200}</div>
			{if $idea.attachment}
				<div>
					<a href="/UserIdea/Export/{$idea.id}?name=attachment"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
					{$idea.attachment.type}
					{$idea.attachment.size|binary_size_format}B
				</div>
			{/if}
			<div>
				{$idea.create_date|date_format:'Y-m-d(ww) H:i'}
				{image_cache class='Account' id=$idea.account.id size='icon' pixel=16}
				{$idea.account.company} {$idea.account.name}
			</div>
		{/if}
	</div>
{/foreach}

<script type="text/javascript">
{literal}
document.observe('dom:loaded', function () {
  new Ajax.Updater('members', '/UserAccount/List');
});
{/literal}
</script>

{include file='UserFooter'}

{* vim: set tabstop=4: *}
