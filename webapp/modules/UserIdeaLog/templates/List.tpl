{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminTag
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
<h2>■{$action.title}</h2>
<table>
	<tr>
		<th width="120">日付</th>
		<th width="240">作業者</th>
		<th width="240">内容</th>
	</tr>

{foreach from=$logs item='log' name='logs'}
	<tr>
		<td width="120" align="center">{$log.create_date|date_format:'Y.m.d(ww) H:i'}</td>
		<td width="240">
			{image_cache size='icon' class='Account' id=$log.account.id pixel=16}
			{$log.account.company} {$log.account.name}
		</td>
		<td width="240">{$log.body}</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="3" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

{* vim: set tabstop=4: *}
