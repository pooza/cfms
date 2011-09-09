{*
ファイル詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserIdea
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='profile'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<h2 class="profile_img large">
		コメント:{$idea.name|default:'(無題)'}
	</h2>
	<div class="form_box">
		<table border="0" cellspacing="4" cellpadding="0">
			<tr>
				<th class="large form_text">
					<p><strong>No.</strong></p>
				</th>
				<td>{$idea.serial}</td>
			</tr>
			<tr>
				<th class="large form_text" style="">
					<p>
						<strong>コメント</strong>
					</p>
				</th>
				<td>
					<div style="margin:5px 0">
						{$idea.body|nl2br}
					</div>
				</td>
			</tr>
			<tr>
				<th class="large form_text">
					<p><strong>作成者</strong></p>
				</th>
				<td class="normal">
					{image_cache class='Account' id=$idea.account.id size='icon' pixel=16}
					{$idea.account.company} {$idea.account.name}
				</td>
			</tr>
			<tr>
				<th class="large form_text">
					<p><strong>作成日</strong></p>
				</th>
				<td>{$idea.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<th class="large form_text">
					<p><strong>更新日</strong></p>
				</th>
				<td>{$idea.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
		</table>
	</div>

{*
	{include file='Detail.thread.tpl'}
	{form action='Comment'}
		<div align="center">
			<textarea name="body" cols="48" rows="5" class="input04" style="width:520px"></textarea><br/>
			<input type="submit" value="送信" />
		</div>
	{/form}
*}
</div>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
