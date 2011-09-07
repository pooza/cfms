{*
ファイル詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserIdea
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='UserHeader'}

<div id="BreadCrumbs">
	<a href="/UserProject/">プロジェクト一覧</a>
	<a href="/UserProject/{$list_action.name}/{$project.id}">プロジェクト:{$project.name}</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>
{if $idea.parent}
	<table class="detail">
		<tr>
			<th>{$module.record_class|translate}ID</th>
			<td>{$idea.id}</td>
		</tr>
		<tr>
			<th>名前</th>
			<td>{$idea.name|default:'(空欄)'}</td>
		</tr>
		<tr>
			<th>名前(英)</th>
			<td>{$idea.name_en|default:'(空欄)'}</td>
		</tr>
		<tr>
			<th>フリガナ</th>
			<td>{$idea.name_read|default:'(空欄)'}</td>
		</tr>
		<tr>
			<th>本文</th>
			<td>{$idea.body|nl2br|default:'(空欄)'}</td>
		</tr>
		<tr>
			<th>作成者</th>
			<td>
				{image_cache class='Account' id=$idea.account.id size='icon' pixel=16}
				{$idea.account.company} {$idea.account.name}
			</td>
		</tr>
		<tr>
			<th>親</th>
			<td>
				<a href="/UserIdea/Detail/{$idea.parent.id}">{$idea.parent.name}</a><br/>
				{$idea.parent.body|nl2br}
			</td>
		</tr>
		<tr>
			<th>作成日</th>
			<td>{$idea.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
		</tr>
		<tr>
			<th>更新日</th>
			<td>{$idea.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="button" value="この{$module.record_class|translate}を削除..." onclick="CarrotLib.confirmDelete('{$module.name}','Delete','{$module.record_class|translate}')" />
			</td>
		</tr>
	</table>
{else}
	{form attachable=true}
		{include file='ErrorMessages'}
		<table class="detail">
			<tr>
				<th>{$module.record_class|translate}ID</th>
				<td>{$idea.id}</td>
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
				<th>フォルダ</th>
				<td>
					{html_checkboxes name="tags" values=$tags output=$tags selected=$params.tags separator='<br/>'}
				</td>
			</tr>
			<tr>
				<th>本文</th>
				<td>
					<textarea name="body" cols="60" rows="5" />{$params.body}</textarea>
				</td>
			</tr>
			<tr>
				<th>ファイル</th>
				<td>
					<input type="file" name="attachment" size="20" /><br/>
					{if $idea.has_attachment}
					<div class="common_block">
						{if $idea.is_image}
							{image_cache size='attachment' pixel=240 style_class='bordered'}<br/>
						{/if}
						<a href="/{$module.name}/Export/{$idea.id}?name=attachment"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
						{$idea.attachment.type}
						{$idea.attachment.size|binary_size_format}B ({$idea.attachment.size|number_format}B)
					</div>
					{/if}
				</td>
			</tr>
			<tr>
				<th>作成者</th>
				<td>
					{image_cache class='Account' id=$idea.account.id size='icon' pixel=16}
					{$idea.account.company} {$idea.account.name}
				</td>
			</tr>
			<tr>
				<th>作成日</th>
				<td>{$idea.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{$idea.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="更新" />
					<input type="button" value="この{$module.record_class|translate}を削除..." onclick="CarrotLib.confirmDelete('{$module.name}','Delete','{$module.record_class|translate}')" />
				</td>
			</tr>
		</table>
	{/form}
{/if}

{if $idea.parent}
{else}
<table class="detail">
	<tr>
		<th>宛先</th>
		<td>
			<div id="members" class="common_block">
				{html_checkboxes name='members' options=$accounts checked=$params.members separator='<br/>'}
			</div>
			<input type="button" id="members_checkall_button" value="全て選択" />
			<input type="button" id="members_uncheckall_button" value="全て解除" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="button" id="send_button" value="{$module.record_class|translate}の情報をメールで送信" />
		</td>
	</tr>
</table>
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

{form action='Comment'}
	<table class="detail">
		<tr>
			<th>コメント</th>
			<td>
				{foreach from=$comments item='comment'}
					<div class="comment_entry common_block">
						{if $comment.delete_date}
							<p class="alert">削除済みです。</p>
						{else}
							{$comment.body|nl2br}<br/>
							<a href="/UserIdea/Detail/{$comment.id}">{$comment.create_date|date_format:'Y-m-d(ww) H:i'}</a>
							{image_cache class='Account' id=$comment.account.id size='icon' pixel=16}
							{$comment.account.company} {$comment.account.name}
						{/if}
					</div>
				{/foreach}

				<textarea name="body" cols="48" rows="5"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="送信" />
			</td>
		</tr>
	</table>
{/form}
{/if}

{include file='UserFooter'}

{* vim: set tabstop=4: *}
