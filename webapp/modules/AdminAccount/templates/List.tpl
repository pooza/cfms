{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

{form method="get" style_class='common_block'}
	<input type="text" name="key" value="{$params.key}" />
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
	<tr>
		<th width="60">ID</th>
		<th width="32"></th>
		<th width="210">会社</th>
		<th width="150">名前</th>
	</tr>
	<tr>
		<td colspan="4">
			<a href="/{$module.name}/Create">新しい{$module.record_class|translate}を登録...</a>
		</td>
	</tr>

{foreach from=$accounts item='account'}
	<tr class="{$account.status}">
		<td width="60" align="right">{$account.id}</td>
		<td width="32" align="center">{image_cache id=$account.id size='icon' pixel=32}</td>
		<td width="210">{$account.company}</td>
		<td width="150"><a href="/{$module.name}/Detail/{$account.id}">{$account.name}</a></td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4" class="alert">未登録です。</td>
	</tr>
{/foreach}

	<tr>
		<td colspan="4" style="text-align:center">
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
