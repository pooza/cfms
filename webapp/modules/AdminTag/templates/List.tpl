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
		<th width="180">名前</th>
		<th width="180">名前(英)</th>
	</tr>
	<tr>
		<td colspan="2">
			<a href="/{$module.name}/Create">新しい{$module.record_class|translate}を登録...</a>
		</td>
	</tr>

{foreach from=$tags item='tag' name='tags'}
	<tr class="{$tag.status}">
		<td width="180"><a href="/{$module.name}/Detail/{$tag.id}">{$tag.name}</a></td>
		<td width="180">{$tag.name_en|default:'(未定義)'}</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="2" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

{* vim: set tabstop=4: *}
