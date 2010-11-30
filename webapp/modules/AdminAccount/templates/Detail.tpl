{*
アカウント詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="/{$module.name}/">{$module.record_class|translate}一覧</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

<div class="tabs10">
	<ul id="Tabs">
		<li><a href="#DetailForm"><span>{$module.record_class|translate}詳細</span></a></li>
		<li><a href="#ProjectList"><span>プロジェクト</span></a></li>
	</ul>
</div>

<div id="DetailForm" class="panel">
	{form}
		<h2>■{$module.record_class|translate}詳細</h2>

		{include file='ErrorMessages'}

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
</div>

<div id="ProjectList" class="panel"></div>

<script type="text/javascript">
document.observe('dom:loaded', function(){ldelim}
  new ProtoTabs('Tabs', {ldelim}
    defaultPanel:'{$params.pane|default:'DetailForm'}',
    ajaxUrls: {ldelim}
      ProjectList: '/AdminProject/ListByAccount'
    {rdelim}
  {rdelim});
{rdelim});
</script>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
