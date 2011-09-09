{*
ファイル登録画面テンプレート

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
		{if $list_action.name=='Tags'}
			新しいファイルをアップする
		{else}
			新規コメントする
		{/if}
	</h2>
	{include file='ErrorMessages'}
	{form attachable=true}
		<div class="form_box">
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<th class="large form_text">
						<p>
							<strong>
								本文
							</strong>
						</p>
					</th>
					<td>
						<textarea name="body" cols="60" rows="10" class="input04" />{$params.body}</textarea>
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>ファイル</strong></p>
					</th>
					<td class="normal">
						<input type="file" name="attachment" size="20" class="green_solid" />
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>フォルダ</strong></p>
					</th>
					<td class="normal">
						<div style="margin:5px 0">
							{html_checkboxes name="tags" values=$tags output=$tags selected=$params.tags separator='<br/>'}
						</div>
					</td>
				</tr>
			</table>
			<input type="image" src="/images/profile_update_btn.gif" alt="更新" value="更新" class="inputbtn">
		</div>
	{/form}

	<div align="right">
		<a href="/UserProject/{$list_action.name}/{$project.id}"><img src="/images/back_link.gif" alt="BACK" width="97" height="45"></a>
	</div>
</div>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
