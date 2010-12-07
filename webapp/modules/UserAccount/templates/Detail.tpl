{*
アカウント詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='UserHeader'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form attachable=true}
	<table class="detail">
		<tr>
			<th>{$module.record_class|translate}ID</th>
			<td>{$account.id}</td>
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
			<th>会社</th>
			<td>
				<input type="text" name="company" value="{$params.company}" size="40" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>会社(英)</th>
			<td>
				<input type="text" name="company_en" value="{$params.company_en}" size="40" maxlength="64" class="english" />
			</td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>
				<input type="text" name="email" value="{$params.email}" size="40" maxlength="64" class="english" />
			</td>
		</tr>
		<tr>
			<th>パスワード</th>
			<td>
				<input type="password" name="password" size="20" /><br/>
				<input type="password" name="password_confirm" size="20" />(確認)<br/>
				<span class="alert">※ 変更するときだけ入力してください。</span>
			</td>
		</tr>
		<tr>
			<th>アイコン</th>
			<td>
				<input type="file" name="icon" size="20" /><br/>
{if $account.has_icon}
				<div class="common_block">
					{image_cache size='icon' pixel=32 style_class='bordered'}<br/>
					{image_cache size='icon' mode='size'}
					[<a href="/{$module.name}/DeleteImage?name=icon">この画像を削除</a>]
				</div>
{/if}
			</td>
		</tr>
		<tr>
			<th>状態</th>
			<td>
				{html_radios name='status' options=$status_options selected=$params.status}
			</td>
		</tr>
		<tr>
			<th>作成日</th>
			<td>{$account.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
		</tr>
		<tr>
			<th>更新日</th>
			<td>{$account.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
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
