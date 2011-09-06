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

{form method="get" style_class='common_block'}
	<input type="text" name="key" value="{$params.key}" />
	<input type="submit" value="抽出" />
{/form}

<h1>{strip}
	{image_cache size='logo' class='Project' id=$project.id style_class='bordered'}
	{$action.title}
{/strip}</h1>

<div id="members" class="common_block"></div>

<div id="tag_index" class="common_block">
	<h2>tag_index</h2>
	{foreach from=$ideasets item='ideaset'}
		[<a href="#tag_{$ideaset.tag.name|urlencode}">{$ideaset.tag.name}</a>]
	{foreachelse}
		(フォルダ未登録)
	{/foreach}
</div>
<div>
	[<a href="/{$module.name}/Wall/{$project.id}">ウォールビュー</a>]
	[<a href="/{$module.name}/Tags/{$project.id}">フォルダビュー</a>]
</div>

{form module='UserTag' action='Create' style_class='common_block'}
	<h2>フォルダ登録</h2>
	{include file='ErrorMessages'}
	<input type="text" name="name" />
	<input type="submit" value="登録" />
{/form}

{foreach from=$ideasets item='ideaset'}
<div id="tag_{$ideaset.tag.name|urlencode}" class="tag_entry common_block">
<h2><a href="/UserTag/Detail/{$ideaset.tag.id}">フォルダ:{$ideaset.tag.name}</a></h2>

<table class="idea_list">
	<tr>
		<th width="32"></th>
		<th width="300">名前</th>
		<th width="60">サイズ</th>
		<th width="90">タイプ</th>
		<th width="90">更新日</th>
		<th width="20"></th>
	</tr>
	<tr>
		<td colspan="6">
			<a href="/UserIdea/Create?tags={$ideaset.tag.name|urlencode}">新しいファイルを登録...</a>
		</td>
	</tr>

	{foreach from=$ideaset.ideas item='idea'}
		<tr class="{$idea.status}">
			<td width="32" align="center">
				{if $idea.is_image}{image_cache class='Idea' id=$idea.id size='attachment' pixel=32}{/if}
			</td>
			<td width="300">
				<a href="/UserIdea/Detail/{$idea.id}">{$idea.name}</a>
				{if $idea.body}<br/><span class="body">{$idea.body|truncate:48}</span>{/if}
			</td>
			<td width="60" align="right">{$idea.attachment.size|binary_size_format}B</td>
			<td width="90">{$idea.attachment.type}</td>
			<td width="90" align="center">{$idea.update_date|date_format:'Y.m.d(ww)'}</td>
			<td width="20" align="center">
				<a href="/UserIdea/Export/{$idea.id}?name=attachment"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
			</td>
		</tr>
	{/foreach}
	</table>

	[<a href="#tag_index">↑#tag_index</a>]
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
