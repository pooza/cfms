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
	<h2 class="profile_img large">ファイル:{$idea.name}</h2>
	{include file='ErrorMessages'}
	{form attachable=true}
		<div class="form_box">
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<th class="large form_text">
						<p><strong>No.</strong></p>
					</th>
					<td>{$idea.serial}</td>
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
						<p>
							<strong>本文</strong>
						</p>
					</th>
					<td>
						<textarea name="body" cols="60" rows="10" class="input04" />{$params.body}</textarea>
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
				<tr>
					<th class="large form_text">
						<p><strong>ファイル</strong></p>
					</th>
					<td class="normal">
						<input type="file" name="attachment" size="20" class="green_solid" /><br/>
						{if $idea.is_image}
							{image_cache size='attachment' pixel=240 style_class='bordered'}<br/>
						{/if}
						<a href="/{$module.name}/Export/{$idea.id}?name=attachment"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
						{$idea.attachment.type}
						{$idea.attachment.size|binary_size_format}B ({$idea.attachment.size|number_format}B)
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
			<input type="image" src="/images/profile_Update_btn.gif" alt="更新" value="更新" class="inputbtn">
		</div>
	{/form}

	<div class="form_box">
		<table border="0" cellspacing="4" cellpadding="0">
			<tr>
				<th class="large form_text">
					<p><strong>宛先</strong></p>
				</th>
				<td>
					<div style="margin:5px 0" class="normal">
						<div id="members">
							{html_checkboxes name='members' options=$accounts checked=$params.members separator='<br/>'}
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th class="large form_text">
				</th>
				<td>
					<div style="margin:5px 0">
						<input type="button" id="members_checkall_button" value="全て選択" />
						<input type="button" id="members_uncheckall_button" value="全て解除" />
						<input type="button" id="send_button" value="{$module.record_class|translate}の情報をメールで送信" />
					</div>
				</td>
			</tr>
		</table>
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

  $('send_button').observe('click', function() {
    var members = [];
    $$('#members input').each(function (element) {
      if (element.checked) {
        members.push(element.value);
      }
    });
    if (members = members.join(',')) {
      new Ajax.Request('/UserIdea/Send', {
        parameters: 'accounts=' + members,
        onSuccess:function (response) {
          updateCheckBoxes(false);
          alert('メールを送信しました。');
        },
        onFailure: function (response) {
          updateCheckBoxes(false);
          alert('メールの送信に失敗しました。 ' + response.responseText);
        }
      });
    }
  });

  $('members_checkall_button').observe('click', function() {
    updateCheckBoxes(true);
  });

  $('members_uncheckall_button').observe('click', function() {
    updateCheckBoxes(false);
  });
});
{/literal}
</script>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
