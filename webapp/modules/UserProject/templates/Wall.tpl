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

{include file='ErrorMessages'}

<h1>{strip}
	{image_cache size='logo' class='Project' id=$project.id style_class='bordered'}
	{$action.title}
{/strip}</h1>

<div id="members" class="common_block">
	[<a id="account_list_link" href="#">メンバー...</a>]
</div>

<div id="tag_index" class="common_block">
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

<h2>ウォール</h2>

{include file='UserFooter'}

{* vim: set tabstop=4: *}
