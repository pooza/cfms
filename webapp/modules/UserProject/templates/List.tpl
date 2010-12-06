{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='UserHeader'}

{form method="get" style_class='common_block'}
	<input type="text" name="key" value="{$params.key}" />
	<input type="submit" value="抽出" />
	<input type="button" value="抽出の解除" onclick="CarrotLib.redirect('{$module.name}','ListAll')" />
{/form}

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="32"></th>
		<th width="300">名前</th>
		<th width="180">期間</th>
	</tr>

{foreach from=$projects item='project'}
	<tr class="{$project.status}">
		<td width="32" align="center">{image_cache id=$project.id size='logo' pixel=32}</td>
		<td width="300"><a href="/{$module.name}/Detail/{$project.id}">{$project.name}</a></td>
		<td width="180" align="center">
			{if $project.start_date||$project.end_date}
				{$project.start_date|date_format:'Y.m.d'}〜{$project.end_date|date_format:'Y.m.d'}
			{/if}
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
