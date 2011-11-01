{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='project'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<table cellspacing="0" cellpadding="0" class="tbl_project-layout">
		<tr>
			<td valign="top" class="leftArea">
				<p class="project-img">
					{image_cache class='Project' id=$project.id size='logo' pixel=230}
				</p>
				<div class="memberColumn normal">
					<p class="ttlMember"><img src="/images/project_ttl-member.gif" width="86" height="31" alt="MEMBER"></p>
					<div id="members">Loading...</div>
				</div>
			</td>
			<td valign="top" class="rightArea">
				<div class="searchColumn">
					{form method='get'}
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td class="form"><input name="key" value="{$params.key}" type="text" class="text"></td>
								<td class="btn"><input type="image" src="/images/bt_search.gif" width="37" height="33" alt="検索する"></a></td>
							</tr>
						</table>
					{/form}
				</div>
				<table cellspacing="0" cellpadding="0" class="project-title">
					<tr>
						<td valign="bottom" class="icon"><img src="/images/project_ttl-icon.gif" width="106" height="112" alt=""></td>
						<td valign="bottom" class="padBtm">
							<p class="title_txt">{$project.name}</p>
						</td>
					</tr>
				</table>
				<p class="bnr_upload"><a href="/UserIdea/Create"><img src="/images/project_bnr-newupload_comment.gif" width="531" height="78" alt="新規コメントする"></a></p>
				<table cellspacing="0" cellpadding="0" class="tab-menu roll">
					<tr>
						<td valign="top">
							<a href="/UserProject/Wall/{$project.id}"><img src="/images/project_menu-wall_on.gif" width="255" height="46" alt="WALL" class="unroll"></a>
						</td>
						<td align="right" valign="top">
							<a href="/UserProject/Tags/{$project.id}"><img src="/images/project_menu-folder.gif" width="255" height="46" alt="FOLDER"></a>
						</td>
					</tr>
				</table>

				{foreach from=$ideas item='idea'}
					<div class="commentColumn {if $idea.is_important}imp{/if}">
						<div class="bgtop">
							<div class="bgbtm">
								<table cellspacing="0" cellpadding="0" class="tbl_comment">
									<tr>
										<td valign="top" class="itemHead">
											<p class="number"><strong>{$idea.serial}</strong></p>
										</td>
										<td valign="top" class="itemContents">
											<table cellspacing="0" cellpadding="0" class="tbl_name">
												<tr>
													<th valign="top" scope="row">
														{if $idea.is_image}
															{image_cache class='Account' id=$idea.account.id size='icon' pixel=60}
														{else}
															<img src="/images/project_icon-file.gif" width="31" height="40" alt="">
														{/if}
													</th>
													<td valign="top" class="nameTxt normal">{$idea.account.company}<br/>{$idea.account.name}様</td>
													<td valign="top" class="dayTxt small">{$idea.create_date|date_format:'Y.m.d H:i:s'}</td>
												</tr>
											</table>
											<p class="commentTxt normal">
												{if $idea.delete_date}
													(削除済みです)
												{else}
													{$idea.body|nl2br}
												{/if}
											</p>
											{if !$idea.delete_date}
												<table cellspacing="0" cellpadding="0" class="tbl_file">
													<tr>
														<td class="file">
															{if $idea.has_attachment}
																<a href="/UserIdea/Export/{$idea.id}?name=attachment">{strip}
																	{if $idea.is_image}
																		{image_cache class='Idea' id=$idea.id size='attachment' pixel=40}
																	{else}
																		<img src="/images/project_icon-file.gif" width="31" height="40" alt="">
																	{/if}
																{/strip}</a>
															{/if}
														</td>
														<td class="txt normal">
															{if $idea.has_attachment}
																ファイル:<strong><a href="/UserIdea/Export/{$idea.id}?name=attachment">{$idea.name}</a></strong>
																({$idea.attachment.size|binary_size_format}B)
															{/if}
														</td>
														<td valign="bottom" class="reComment">
															<a href="/UserIdea/Thread/{$idea.id}"><img src="/images/project_icon-comment01.gif" width="37" height="31" alt=""></a>
														</td>
													</tr>
												</table>
											{/if}
										</td>
									</tr>
								</table>

								{foreach from=$idea.comments item='comment'}
									<div class="border">
										<table cellspacing="0" cellpadding="0" class="tbl_comment">
											<tr>
												<td valign="top" class="itemHead"></td>
												<td valign="top" class="itemContents">
													<table cellspacing="0" cellpadding="0" class="tbl_name">
														<tr>
															<th valign="top" scope="row">{image_cache class='Account' id=$comment.account.id size='icon' pixel=40}</th>
															<td valign="top" class="nameTxt sec normal">{$comment.account.company}<br>{$comment.account.name}様</strong></a></td>
															<td valign="top" class="text normal">
																<p>{$comment.body|nl2br}</p>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</div>
								{/foreach}

							</div>
						</div>
					</div>
				{foreachelse}
					<div class="commentColumn"></div>
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
