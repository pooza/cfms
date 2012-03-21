{*
ファイル登録画面テンプレート

@package jp.co.commons.cfms
@subpackage UserDelivery
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='profile'}
{include file='UserHeader'}

<div id="container">
	{$delivery.recipient}様<br/>
	コモンズ株式会社（{$delivery.account.name}）が下記ファイルをアップいたしました。<br/>
	ファイル名 {$delivery.filename}<br/>
	ファイル容量 {$delivery.attachment.size|binary_size_format}B<br/>
	保管期限 {$delivery.expire_date|date_format:'Y/m/d H:i:s'}<br/>
	コメント:<br/>
	{$delivery.comment|nl2br|default:'(空欄)'}
	<hr/>

	{form action='Download'}
		<br/><br/>
		{include file='ErrorMessages'}
		<label>パスワード<input type="password" name="password" /></label><br/>
		<input type="image" src="/images/download_btn.gif" alt="ダウンロード" value="ダウンロード" class="inputbtn">
	{/form}

	{form action='Fix'}
		<br/><br/>ファイルを受け取ることができましたら、このボタンを押してください。<br/>
		<input type="image" src="/images/fix_btn.gif" alt="完了通知" value="完了通知" class="inputbtn">
	{/form}
</div>

{include file='UserFooter'}

{* vim: set tabstop=4: *}
