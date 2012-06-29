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
  <h2 class="profile_img large">ファイル: {$idea.name}</h2>
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
            <p><strong>ファイル</strong></p>
          </th>
          <td class="normal">
            <input type="file" name="attachment" size="20" class="green_solid"><br><br>
            <span class="alert">{$errors.attachment}</span>
            {if $idea.is_image}
              {image_cache size='attachment' pixel=240 style_class='bordered'}<br>
            {/if}
            <a href="/{$module.name}/Export/{$idea.id}?name=attachment"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード"></a>
            {$idea.attachment.type}
            {$idea.attachment.size|binary_size_format}B ({$idea.attachment.size|number_format}B)
          </td>
        </tr>
        <tr>
          <th class="large form_text">
            <p><strong>フォルダ</strong><span class="alert">(必須)</span></p>
          </th>
          <td class="normal">
            <div style="margin:5px 0">
              {html_checkboxes name="tags" values=$tags output=$tags selected=$params.tags separator='<br>'}
              <span class="alert">{$errors.tags}</span>
            </div>
          </td>
        </tr>
        <tr>
          <th class="large form_text">
            <p><strong>ファイル名</strong><span class="alert">(必須)</span></p>
          </th>
          <td>
            <input type="text" name="name" value="{$params.name}" maxlength="64" class="input01"><br>
            拡張子は含めないでください。<br>
            <span class="alert">{$errors.name}</span>
          </td>
        </tr>
        <tr>
          <th class="large form_text">
            <p>
              <strong>コメント</strong>
            </p>
          </th>
          <td>
            <textarea name="body" cols="60" rows="10" class="input04">{$params.body}</textarea><br>
            <span class="alert">{$errors.body}</span>
          </td>
        </tr>
        <tr>
          <th class="large form_text">
            <p><strong>通知宛先</strong></p>
          </th>
          <td>
            <div style="margin:5px 0" class="normal">
              <div id="members">
                {html_checkboxes name='members' options=$accounts checked=$params.members separator='<br>'}
                <span class="alert">{$errors.members}</span>
              </div>
              <input type="button" id="members_checkall_button" value="全て選択">
              <input type="button" id="members_uncheckall_button" value="全て解除">
            </div>
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
      <input type="image" src="/images/profile_update_btn.gif" alt="更新" value="更新" class="inputbtn">
      <img id="delete_btn" src="/images/delete_btn.gif" alt="削除" class="inputbtn">
      <a href="/{$module.name}/Export/{$idea.id}?name=attachment"><img id="download_btn" src="/images/idea_download_btn.gif" alt="DOWNLOAD" class="inputbtn"></a>
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
