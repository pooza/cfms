{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

{form method="get" style_class='common_block'}
	<input type="text" name="key" value="{$params.key}" />
	<select name="type">
		<option value="">種類...</option>
		{html_options options=$type_options selected=$params.type}
	</select>
	<select name="status">
		<option value="">状態...</option>
		{html_options options=$status_options selected=$params.status}
	</select>
	<input type="submit" value="抽出" />
	<input type="button" value="抽出の解除" onclick="CarrotLib.redirect('{$module.name}','ListAll')" />
{/form}

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<colgroup>
		<col width="30" />
		<col width="32" />
		<col width="210" />
		<col width="150" />
		<col width="90" />
	</colgroup>
	<tr>
		<th>ID</th>
		<th></th>
		<th>会社</th>
		<th>名前</th>
		<th>種類</th>
	</tr>
	<tr>
		<td colspan="5">
			<a href="/{$module.name}/Create">新しい{$module.record_class|translate}を登録...</a>
		</td>
	</tr>
	{foreach from=$accounts item='account'}
		<tr class="{$account.status}">
			<td align="right">{$account.id}</td>
			<td align="center">{image_cache id=$account.id size='icon' pixel=32}</td>
			<td>{$account.company|default:'(空欄)'}</td>
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
				<span><a href="{if 1<$page}/{$module.name}/{$action.name}?page=1{else}javascript:void(){/if}"><img src="/carrotlib/images/navigation_arrow/left3.gif" width="14" height="14" alt="|&lt;" /></a></span>&nbsp;
				<span><a href="{if 1<$page}/{$module.name}/{$action.name}?page={$page-1}{else}javascript:void(){/if}"><img src="/carrotlib/images/navigation_arrow/left1.gif" width="14" height="14" alt="&lt;" /></a></span>&nbsp;
				[{$page}]&nbsp;
				<span><a href="{if $page<$lastpage}/{$module.name}/{$action.name}?page={$page+1}{else}javascript:void(){/if}"><img src="/carrotlib/images/navigation_arrow/right1.gif" width="14" height="14" alt="&gt;" /></a></span>&nbsp;
				<span><a href="{if $page<$lastpage}/{$module.name}/{$action.name}?page={$lastpage}{else}javascript:void(){/if}"><img src="/carrotlib/images/navigation_arrow/right3.gif" width="14" height="14" alt="&gt;|" /></a></span>
			{/strip}
		</td>
	</tr>
</table>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
