{*
ファイル登録画面テンプレート

@package jp.co.commons.cfms
@subpackage UserDelivery
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='profile'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<h2 class="profile_img large">
		DELIVERY
	</h2>
	{include file='ErrorMessages'}
	{form attachable=true}
		<div class="form_box">
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<th class="large form_text">
						<p><strong>お名前</strong></p>
					</th>
					<td>
						<input type="text" name="recipient" value="{$params.recipient}" maxlength="64" class="input01" />
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>メールアドレス</strong></p>
					</th>
					<td>
						<input type="text" name="email" value="{$params.email}" maxlength="64" class="input01" />
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
						<p><strong>保存期間</strong></p>
					</th>
					<td>{html_radios name='preserve_duration' options=$duration_options selected=$params.preserve_duration}</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>パスワード</strong></p>
					</th>
					<td>
						<input type="password" name="password" value="{$params.password}" maxlength="64" class="input01" />
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>コメント</strong></p>
					</th>
					<td>
						<textarea name="comment" cols="60" rows="10" class="input04" />{$params.comment}</textarea>
					</td>
				</tr>
			</table>
			<input type="image" src="/images/send_btn.gif" alt="送信" value="送信" class="inputbtn">
		</div>
	{/form}
</div>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
