{*
アカウント詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='profile'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<h2 class="profile_img large">{strip}
		<img src="/images/profile_textimg.gif" width="130" height="29" alt="PRFILE"><br>
		<strong>{$account.name}様の登録情報</strong>
	{/strip}</h2>
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
				<tr>
					<th class="normal form_text">
						<p><strong>会社</strong></p>
					</th>
					<td>
						<input type="text" name="company" value="{$params.company}" maxlength="64" class="input01" />
					</td>
				</tr>
				<tr>
					<th class="normal form_text">
						<p><strong>メールアドレス</strong></p>
					</th>
					<td>
						<input type="text" name="email" value="{$params.email}" maxlength="64" class="input02" />
					</td>
				</tr>
				<tr>
					<th class="normal form_text">
						<p><strong>パスワード</strong></p>
					</th>
					<td>
						<p class="m15"><input type="password" name="password" class="input03" /></p>
						<p class="m9"><input type="password" name="password_confirm" class="input03" /></p>
						<p class="normal red_font">※変更するときだけ入力してください。</p>
					</td>
				</tr>
				<tr>
					<th class="normal form_text">
						<p><strong>アイコン</strong></p>
					</th>
					<td>
						{image_cache size='icon' pixel=32}
						<input type="file" name="icon" class="green_solid" />
					</td>
				</tr>
			</table>
			<input type="image" src="/images/profile_update_btn.gif" alt="更新" value="更新" class="inputbtn">
		</div>
	{/form}
</div>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
