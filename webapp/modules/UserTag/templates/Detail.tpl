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
						<p><strong>{$module.record_class|translate}ID</strong></p>
					</th>
					<td>{$tag.id}</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>名前</strong></p>
					</th>
					<td>
						<input type="text" name="name" value="{$params.name}" maxlength="64" class="input01" />
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>作成日</strong></p>
					</th>
					<td>{$tag.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>更新日</strong></p>
					</th>
					<td>{$tag.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
				</tr>
			</table>
			<input type="image" src="/images/profile_update_btn.gif" alt="更新" value="更新" class="inputbtn">
			<img id="delete_btn" src="/images/delete_btn.gif" alt="削除" class="inputbtn" />
		</div>
	{/form}

	<div align="right">
		<a href="/UserProject/{$list_action.name}/{$project.id}"><img src="/images/back_link.gif" alt="BACK" width="97" height="45"></a>
	</div>
</div>

<script type="text/javascript">
{literal}
document.observe('dom:loaded', function () {
  $('delete_btn').observe('click', function() {
    CarrotLib.confirmDelete('UserTag', 'Delete', 'フォルダ');
  });
});
{/literal}
</script>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
