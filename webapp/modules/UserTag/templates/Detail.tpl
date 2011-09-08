{*
フォルダ詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserTag
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='profile'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<h2 class="profile_img large">{$action.title}</h2>
	{include file='ErrorMessages'}
	{form attachable=true}
		<div class="form_box">
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<th class="large form_text">
						<p><strong>名前</strong></p>
					</th>
					<td>
						<input type="text" name="name" value="{$params.name}" maxlength="64" class="input01" />
					</td>
				</tr>
			</table>
			<input type="image" src="/images/profile_Update_btn.gif" alt="更新" value="更新" class="inputbtn">
		</div>
	{/form}
</div>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
