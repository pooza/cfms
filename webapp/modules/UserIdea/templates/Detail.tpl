{*
ファイル詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserIdea
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='UserHeader'}

<div id="BreadCrumbs">
	<a href="/UserProject/">プロジェクト一覧</a>
	<a href="/UserProject/Detail/{$project.id}">プロジェクト:{$project.name}</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

<div class="tabs10">
	<ul id="Tabs">
		<li><a href="#DetailForm"><span>{$module.record_class|translate}詳細</span></a></li>
		<li><a href="#MailForm"><span>通知</span></a></li>
		<li><a href="#LogList"><span>履歴</span></a></li>
	</ul>
</div>

<div id="DetailForm" class="panel">
	{form attachable=true}
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
					<textarea id="tags" name="tags" cols="20" rows="10" />{$params.tags}</textarea>
					<div class="tag_cloud" id="tags_TagCloud">
						{foreach from=$tag_cloud item='tag'}
							<a href="javascript:void(CFMSLib.toggleTag($('tags'), '{$tag.name}'))" class="{if $tag.is_selected}selected{/if}">{$tag.name}</a>
						{/foreach}
					</div>
				</td>
			</tr>
			<tr>
				<th>説明</th>
				<td>
					<textarea name="description" cols="60" rows="5" />{$params.description}</textarea>
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
</div>

<div id="MailForm" class="panel">
	<table class="detail">
		<tr>
			<th>宛先</th>
			<td>
				<div id="members" class="common_blick">
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
</div>

<div id="LogList" class="panel"></div>

<script type="text/javascript">
{literal}
document.observe('dom:loaded', function () {
  function updateCheckBoxes (flag) {
    $$('#members input').each(function (element) {
      element.checked = flag;
    });
  }

  var pane = 'DetailForm';
  if (CarrotLib.getQueryParameter('pane')) {
    pane = CarrotLib.getQueryParameter('pane');
  }

  new ProtoTabs('Tabs', {
    defaultPanel: pane,
    ajaxUrls: {
      LogList: '/UserIdeaLog/'
    }
  });

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

{include file='UserFooter'}

{* vim: set tabstop=4: *}
