{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{form method="get" style_class='common_block'}
	<input type="text" id="key" value="{$params.key}" />
	<input type="button" value="抽出" onclick="CFMSLib.updateAccountList()" />
	<input type="button" value="抽出の解除" onclick="CFMSLib.initializeAccountList()" />
{/form}

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="30"></th>
		<th width="32"></th>
		<th width="210">会社</th>
		<th width="150">名前</th>
	</tr>

{foreach from=$accounts item='account'}
	<tr id="account_row_{$account.id}" class="{if $params.accounts[$account.id]}show{else}hide{/if}">
		<td width="30" align="center">
			<input id="account_{$account.id}" type="checkbox" {if $params.accounts[$account.id]}checked="checked"{/if} onchange="CFMSLib.updateAccountStatus(this)" />
		</td>
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
			<span><a href="javascript:void({if 1<$page}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page=1'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/left3.gif" width="14" height="14" alt="|&lt;" /></a></span>&nbsp;
			<span><a href="javascript:void({if 1<$page}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page={$page-1}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/left1.gif" width="14" height="14" alt="&lt;" /></a></span>&nbsp;
			[{$page}]&nbsp;
			<span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page={$page+1}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/right1.gif" width="14" height="14" alt="&gt;" /></a></span>&nbsp;
			<span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('AccountList', '/{$module.name}/{$action.name}?page={$lastpage}'){else}0{/if})"><img src="/carrotlib/images/navigation_arrow/right3.gif" width="14" height="14" alt="&gt;|" /></a></span>
{/strip}
		</td>
	</tr>
</table>

{* vim: set tabstop=4: *}
