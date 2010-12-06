{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserIdea
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='UserHeader'}

<div id="BreadCrumbs">
	<a href="/UserProject/">プロジェクト一覧</a>
	<a href="#">プロジェクト:{$project.name}</a>
</div>

{form method="get" style_class='common_block'}
	<input type="text" name="key" value="{$params.key}" />
	<input type="submit" value="抽出" />
	<input type="button" value="抽出の解除" onclick="CarrotLib.redirect('{$module.name}','ListAll')" />
{/form}

{include file='ErrorMessages'}

<h1>プロジェクト:{$project.name}</h1>
<table>
	<tr>
		<th width="32"></th>
		<th width="300">名前</th>
		<th width="20"></th>
	</tr>
	<tr>
		<td colspan="3">
			<a href="/{$module.name}/Create">新しい{$module.record_class|translate}を登録...</a>
		</td>
	</tr>

{foreach from=$ideas item='idea'}
	<tr class="{$idea.status}">
		<td width="32" align="center">
			{if $idea.is_image}{image_cache id=$idea.id size='attachment' pixel=32}{/if}
		</td>
		<td width="300"><a href="/{$module.name}/Detail/{$idea.id}">{$idea.name}</a></td>
		<td width="20" align="center">
			<img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" />
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3" class="alert">未登録です。</td>
	</tr>
{/foreach}

	<tr>
		<td colspan="3" style="text-align:center">
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

{include file='UserFooter'}

{* vim: set tabstop=4: *}
