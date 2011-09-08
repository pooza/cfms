{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='folder'}
{assign var='links.project.class' value='unroll'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<table cellspacing="0" cellpadding="0" class="tbl_project-layout">
		<tr>
			<td valign="top" class="leftArea">
				<p class="project-img">
					{image_cache size='logo' pixel=230}
				</p>
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
							<p class="title_txt">{$project.name}</p>
						</td>
					</tr>
				</table>
				<p class="bnr_upload"><a href="/UserIdea/Create"><img src="/images/project_bnr-newupload.gif" width="531" height="78" alt="新しいファイルをアップする"></a></p>
				<table cellspacing="0" cellpadding="0" class="tab-menu roll">
					<tr>
						<td valign="top">
							<a href="/UserProject/Wall/{$project.id}"><img src="/images/project_menu-wall.gif" width="255" height="46" alt="WALL"></a>
						</td>
						<td align="right" valign="top">
							<a href="/UserProject/Tags/{$project.id}"><img src="/images/project_menu-folder_on.gif" width="255" height="46" alt="FOLDER" class="unroll"></a>
						</td>
					</tr>
				</table><br/>
				<div class="searchColumn">
					{form module='UserTag' action='Create' style_class='common_block'}
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td class="form"><input name="name" type="text" class="text"></td>
								<td class="btn"><input type="image" src="/images/bt_search.gif" width="37" height="33" alt="検索する"></a></td>
							</tr>
						</table>
					{/form}
				</div>

				{foreach from=$ideasets item='ideaset'}
					<div class="foldertColumn m57">
						<div class="main_table">
							<table width="0" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="top"><img src="/images/folder_img.gif" width="138" height="92" alt=""></td>
									<td>
										<p class="normal"><a href="/UserTag/Detail/{$ideaset.tag.id}">{$ideaset.tag.name}</a></p>
									</td>
								</tr>
							</table>
							<table width="0" border="0" cellspacing="0" class="green_textbox">
								<tr>
									<td width="67">&nbsp;</td>
									<td width="173">名前</td>
									<td width="98">サイズ</td>
									<td width="108">更新日</td>
									<td width="78">&nbsp;</td>
								</tr>
							</table>
							<table cellspacing="0" cellpadding="0" class="pdf_textbox">
								<tr>
									<td colspan="5">
										<a href="/UserIdea/Create?tags={$ideaset.tag.name|urlencode}">新しいファイルをアップする</a>
									</td>
								</tr>

								{foreach from=$ideaset.ideas item='idea'}
									<tr>
										<td width="67">
											{if $idea.is_image}
												{image_cache class='Idea' id=$idea.id size='attachment' pixel=40}
											{else}
												<img src="/images/project_icon-file.gif" width="31" height="40" alt="">
											{/if}
										</td>
										<td width="173">
											<a href="/UserIdea/Detail/{$idea.id}">{$idea.name|default:'(空欄)'}</a>
										</td>
										<td width="98">{$idea.attachment.size|binary_size_format}B</td>
										<td width="108">{$idea.update_date|date_format:'Y.m.d(ww)'}</td>
										<td width="78"><a href="/UserIdea/Export/{$idea.id}?name=attachment"><img src="/images/folder_downlorad_icon.gif" width="59" height="51" alt=""></a></td>
									</tr>
								{/foreach}

							</table>
							<p><a href="#pagetop"><img src="/images/folder_topicon.gif" width="39" height="19" alt=""></a></p>
						</div>
					</div>
				{/foreach}

			</td>
		</tr>
	</table>
</div>

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
