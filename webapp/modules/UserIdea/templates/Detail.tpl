{*
ファイル詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminIdea
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='UserHeader'}

<div id="BreadCrumbs">
	<a href="/UserProject/">プロジェクト一覧</a>
	<a href="/UserProject/Detail/{$project.id}">プロジェクト:{$project.name}</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form attachable=true}
	<table class="detail">
		<tr>
			<th>{$module.record_class|translate}ID</th>
			<td>{$idea.id}</td>
		</tr>
		<tr>
			<th>名前</th>
			<td>
				<input type="text" name="name" value="{$params.name}" size="40" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>名前(英)</th>
			<td>
				<input type="text" name="name_en" value="{$params.name_en}" size="40" maxlength="64" class="english" />
			</td>
		</tr>
		<tr>
			<th>フリガナ</th>
			<td>
				<input type="text" name="name_read" value="{$params.name_read}" size="40" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>ファイル</th>
			<td>
				<input type="file" name="attachment" size="20" /><br/>
				{if $idea.has_attachment}
				<div class="common_block">
					<img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" />
					{$idea.attachment.type}
					{$idea.attachment.size|binary_size_format}B
				</div>
				{/if}
			</td>
		</tr>
		<tr>
			<th>作成日</th>
			<td>{$idea.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
		</tr>
		<tr>
			<th>更新日</th>
			<td>{$idea.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="更新" />
				<input type="button" value="この{$module.record_class|translate}を削除..." onclick="CarrotLib.confirmDelete('{$module.name}','Delete','{$module.record_class|translate}')" />
			</td>
		</tr>
	</table>
{/form}

{include file='UserFooter'}

{* vim: set tabstop=4: *}
