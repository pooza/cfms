{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminProject
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{form method="get" style_class='common_block'}
	<input type="text" id="key" value="{$params.key}" />
	<input type="button" value="抽出" onclick="CFMSLib.updateProjectList()" />
	<input type="button" value="抽出の解除" onclick="CFMSLib.initializeProjectList()" />
{/form}

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="30"></th>
		<th width="300">名前</th>
		<th width="180">期間</th>
	</tr>

{foreach from=$projects item='project'}
	<tr id="project_row_{$project.id}" class="{if $params.projects[$project.id]}show{else}hide{/if}">
		<td width="30" align="center">
			<input id="project_{$project.id}" type="checkbox" {if $params.projects[$project.id]}checked="checked"{/if} onchange="CFMSLib.updateProjectStatus(this)" />
		</td>
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
			<span><a href="javascript:void({if 1<$page}new Ajax.Updater('ProjectList', '/{$module.name}/{$action.name}?page=1'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/left3.gif" width="14" height="14" alt="|&lt;" /></a></span>&nbsp;
			<span><a href="javascript:void({if 1<$page}new Ajax.Updater('ProjectList', '/{$module.name}/{$action.name}?page={$page-1}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/left1.gif" width="14" height="14" alt="&lt;" /></a></span>&nbsp;
			[{$page}]&nbsp;
			<span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('ProjectList', '/{$module.name}/{$action.name}?page={$page+1}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/right1.gif" width="14" height="14" alt="&gt;" /></a></span>&nbsp;
			<span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('ProjectList', '/{$module.name}/{$action.name}?page={$lastpage}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/right3.gif" width="14" height="14" alt="&gt;|" /></a></span>
{/strip}
		</td>
	</tr>
</table>

{* vim: set tabstop=4: *}
