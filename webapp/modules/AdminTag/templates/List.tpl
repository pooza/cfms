{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminTag
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<h2>■{$action.title}</h2>
<table>
	<tr>
		<th width="180">名前</th>
	</tr>
	<tr>
		<td colspan="1">
			<a href="/{$module.name}/Create">新しい{$module.record_class|translate}を登録...</a>
		</td>
	</tr>

{foreach from=$tags item='tag' name='tags'}
	<tr class="{$tag.status}">
		<td width="180"><a href="/{$module.name}/Detail/{$tag.id}">{$tag.name}</a></td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="1" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

{* vim: set tabstop=4: *}
