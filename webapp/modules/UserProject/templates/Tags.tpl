{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='folder'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<table cellspacing="0" cellpadding="0" class="tbl_project-layout">
		<tr>
			<td valign="top" class="leftArea">
				<p class="project-img"><img src="/images/project_img.gif" width="233" height="233" alt=""></p>
				<div class="memberColumn normal">
					<p class="ttlMember"><img src="/images/project_ttl-member.gif" width="86" height="31" alt="MEMBER"></p>
					<div id="members">Loading...</div>
				</div>
			</td>
			<td valign="top" class="rightArea">
				<div class="searchColumn">
					<form action="#" method="get">
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td class="form"><input name="" type="text" class="text"></td>
								<td class="btn"><a href="#"><img src="/images/bt_search.gif" width="37" height="33" alt="検索する"></a></td>
							</tr>
						</table>
					</form>
				</div>
				<table cellspacing="0" cellpadding="0" class="project-title">
					<tr>
						<td valign="bottom" class="icon"><img src="/images/project_ttl-icon.gif" width="106" height="112" alt=""></td>
						<td valign="bottom" class="padBtm">
							<p class="title_txt">kraft ガム施策</p>
						</td>
					</tr>
				</table>
				<p class="bnr_upload"><a href="#"><img src="/images/project_bnr-newupload.gif" width="531" height="78" alt="新しいファイルをアップする"></a></p>
				<table cellspacing="0" cellpadding="0" class="tab-menu roll">
					<tr>
						<td valign="top"><a href="project.html"><img src="/images/project_menu-wall.gif" width="255" height="46" alt="WALL"></a></td>
						<td align="right" valign="top"><a href="folder.html"><img src="/images/project_menu-folder_on.gif" width="255" height="46" alt="FOLDER" class="unroll"></a></td>
					</tr>
				</table>
				<div class="foldertColumn">
					<div class="main_table">
						<table width="0" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top"><img src="/images/folder_img.gif" width="138" height="92" alt=""></td>
								<td>
									<p class="normal">ファイル名</p>
								</td>
							</tr>
						</table>
						<table width="0" border="0" cellspacing="0" class="green_textbox">
							<tr>
								<td width="67">&nbsp;</td>
								<td width="173">ファイル名</td>
								<td width="98">サイズ</td>
								<td width="108">更新日</td>
								<td width="78">&nbsp;</td>
							</tr>
						</table>
						<table cellspacing="0" cellpadding="0" class="pdf_textbox">
							<tr>
								<td width="67"><img src="/images/folder_pdf_icon.gif" width="44" height="41" alt=""></td>
								<td width="173">00000.pdf</td>
								<td width="98">200kb</td>
								<td width="108">2011/4/23</td>
								<td width="78"><a href="#"><img src="/images/folder_downlorad_icon.gif" width="59" height="51" alt=""></a></td>
							</tr>
							<tr>
								<td width="67"><img src="/images/project_icon-file.gif" width="31" height="40" alt=""></td>
								<td width="173">00000.pdf</td>
								<td width="98">200kb</td>
								<td width="108">2011/4/23</td>
								<td width="78"><a href="#"><img src="/images/folder_downlorad_icon.gif" width="59" height="51" alt=""></a></td>
							</tr>
						</table>
						<p><a href="#pagetop"><img src="/images/folder_topicon.gif" width="39" height="19" alt=""></a></p>
					</div>
				</div>
				<div class="foldertColumn m57">
					<div class="main_table">
						<table width="0" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top"><img src="/images/folder_img.gif" width="138" height="92" alt=""></td>
								<td>
									<p class="normal">ファイル名</p>
								</td>
							</tr>
						</table>
						<table width="0" border="0" cellspacing="0" class="green_textbox">
							<tr>
								<td width="67">&nbsp;</td>
								<td width="173">ファイル名</td>
								<td width="98">サイズ</td>
								<td width="108">更新日</td>
								<td width="78">&nbsp;</td>
							</tr>
						</table>
						<table cellspacing="0" cellpadding="0" class="pdf_textbox">
							<tr>
								<td width="67"><img src="/images/folder_pdf_icon.gif" width="44" height="41" alt=""></td>
								<td width="173">00000.pdf</td>
								<td width="98">200kb</td>
								<td width="108">2011/4/23</td>
								<td width="78"><a href="#"><img src="/images/folder_downlorad_icon.gif" width="59" height="51" alt=""></a></td>
							</tr>
							<tr>
								<td width="67"><img src="/images/project_icon-file.gif" width="31" height="40" alt=""></td>
								<td width="173">00000.pdf</td>
								<td width="98">200kb</td>
								<td width="108">2011/4/23</td>
								<td width="78"><a href="#"><img src="/images/folder_downlorad_icon.gif" width="59" height="51" alt=""></a></td>
							</tr>
						</table>
						<p><a href="#pagetop"><img src="/images/folder_topicon.gif" width="39" height="19" alt=""></a></p>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

{*
<div id="members" class="common_block">
	Loading...
</div>

<div>
	[<a href="/{$module.name}/Wall/{$project.id}">ウォールビュー</a>]
	[<a href="/{$module.name}/Tags/{$project.id}">フォルダビュー</a>]
</div>

{form module='UserTag' action='Create' style_class='common_block'}
	<h2>フォルダ登録</h2>
	{include file='ErrorMessages'}
	<input type="text" name="name" />
	<input type="submit" value="登録" />
{/form}

{foreach from=$ideasets item='ideaset'}
<div id="tag_{$ideaset.tag.name|urlencode}" class="tag_entry common_block">
<h2><a href="/UserTag/Detail/{$ideaset.tag.id}">フォルダ:{$ideaset.tag.name}</a></h2>

<table class="idea_list">
	<tr>
		<th width="32"></th>
		<th width="300">名前</th>
		<th width="60">サイズ</th>
		<th width="90">タイプ</th>
		<th width="90">更新日</th>
		<th width="20"></th>
	</tr>
	<tr>
		<td colspan="6">
			<a href="/UserIdea/Create?tags={$ideaset.tag.name|urlencode}">新しいファイルを登録...</a>
		</td>
	</tr>

	{foreach from=$ideaset.ideas item='idea'}
		<tr class="{$idea.status}">
			<td width="32" align="center">
				{if $idea.is_image}{image_cache class='Idea' id=$idea.id size='attachment' pixel=32}{/if}
			</td>
			<td width="300">
				<a href="/UserIdea/Detail/{$idea.id}">{$idea.name|default:'(空欄)'}</a>
				{if $idea.body}<br/><span class="body">{$idea.body|truncate:48}</span>{/if}
			</td>
			<td width="60" align="right">{$idea.attachment.size|binary_size_format}B</td>
			<td width="90">{$idea.attachment.type}</td>
			<td width="90" align="center">{$idea.update_date|date_format:'Y.m.d(ww)'}</td>
			<td width="20" align="center">
				<a href="/UserIdea/Export/{$idea.id}?name=attachment"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
			</td>
		</tr>
	{/foreach}
</table>
</div>
{/foreach}
*}

<script type="text/javascript">
{literal}
document.observe('dom:loaded', function () {
  new Ajax.Updater('members', '/UserAccount/ListByProject');
});
{/literal}
</script>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
