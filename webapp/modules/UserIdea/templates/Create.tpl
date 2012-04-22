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
	{form attachable=true}
		<div class="form_box">
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<th class="large form_text">
						<p><strong>ファイル名</strong></p>
					</th>
					<td>
						<input type="text" name="name" value="{$params.name}" maxlength="64" class="input01" /><br/>
						{if $list_action.name=='Tags'}
							拡張子は含めないでください。<br/>
						{else}
							ファイルを添付する場合、拡張子は含めないでください。<br/>
						{/if}
						<span class="alert">{$errors.name}</span>
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>本文</strong></p>
					</th>
					<td>
						<textarea name="body" cols="60" rows="10" class="input04" />{$params.body}</textarea><br/>
						<span class="alert">{$errors.body}</span>
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>ファイル</strong></p>
					</th>
					<td class="normal">
						<input type="file" name="attachment" size="20" class="green_solid" /><br/>
						<span class="alert">{$errors.attachment}</span>
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>フォルダ</strong></p>
					</th>
					<td class="normal">
						<div style="margin:5px 0">
							{html_checkboxes name="tags" values=$tags output=$tags selected=$params.tags separator='<br/>'}
							<span class="alert">{$errors.tags}</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="large form_text">
						<p><strong>通知宛先</strong></p>
					</th>
					<td>
						<div style="margin:5px 0" class="normal">
							<div id="members">
								{html_checkboxes name='members' options=$accounts checked=$params.members separator='<br/>'}
								<span class="alert">{$errors.members}</span>
							</div>
							<input type="button" id="members_checkall_button" value="全て選択" />
							<input type="button" id="members_uncheckall_button" value="全て解除" />
						</div>
					</td>
				</tr>
			</table>
			<input type="image" src="/images/send_btn.gif" alt="送信" value="送信" class="inputbtn">
		</div>
	{/form}

	<div align="right">
		<a href="/UserProject/{$list_action.name}/{$project.id}"><img src="/images/back_link.gif" alt="BACK" width="97" height="45"></a>
	</div>
</div>

<script type="text/javascript">
{literal}
document.observe('dom:loaded', function () {
  function updateCheckBoxes (flag) {
    $$('#members input').each(function (element) {
      element.checked = flag;
    });
  }

  $('members_checkall_button').observe('click', function() {
    updateCheckBoxes(true);
  });

  $('members_uncheckall_button').observe('click', function() {
    updateCheckBoxes(false);
  });
  $('delete_btn').observe('click', function() {
    CarrotLib.confirmDelete('UserIdea', 'Delete', 'ファイル');
  });
});
{/literal}
</script>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
