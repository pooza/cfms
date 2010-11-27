{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader' styleset='minc.admin'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="60">ID</th>
		<th width="300">名前</th>
	</tr>
	<tr>
		<td colspan="2">
			<a href="/{$module.name}/Create">新しい{$module.record_class|translate}を登録...</a>
		</td>
	</tr>

{foreach from=$accounts item='account'}
	<tr class="{$account.status}">
		<td width="60" align="right">{$account.id}</td>
		<td width="300"><a href="/{$module.name}/Detail/{$account.id}">{$account.name}</a></td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="2" class="alert">未登録です。</td>
	</tr>
{/foreach}

</table>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
