{*
ファイル詳細画面テンプレート

@package jp.co.commons.cfms
@subpackage UserIdea
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<div id="idea_thread">
	{foreach from=$comments item='comment'}
		<div class="commentColumn {if $comment.is_important}imp{/if}" style="margin:20px auto">
			<div class="bgtop">
				<div class="bgbtm">
					<table cellspacing="0" cellpadding="0" class="tbl_comment">
						<tr>
							<td valign="top" class="itemHead">
								<p class="number"><strong>{$comment.serial}</strong></p>
							</td>
							<td valign="top" class="itemContents">
								<table cellspacing="0" cellpadding="0" class="tbl_name">
									<tr>
										<th valign="top" scope="row">
											{image_cache class='Account' id=$comment.account.id size='icon' pixel=60}
										</th>
										<td valign="top" class="nameTxt normal">{$comment.account.company}<br/>{$comment.account.name}様</td>
										<td valign="top" class="dayTxt small">{$comment.create_date|date_format:'Y.m.d H:i:s'}</td>
									</tr>
								</table>
								<p class="commentTxt normal">
									{if $comment.delete_date}
										(削除済みです)
									{else}
										{$comment.body|nl2br}
									{/if}
								</p>
								<table cellspacing="0" cellpadding="0" class="tbl_file">
									<tr>
										<td class="file">
											{if !$comment.delete_date && $comment.has_attachment}
												<a href="/UserIdea/Export/{$comment.id}?name=attachment">{strip}
													{if $comment.is_image}
														{image_cache class='Idea' id=$comment.id size='attachment' pixel=40}
													{else}
														<img src="/images/project_icon-file.gif" width="31" height="40" alt="">
													{/if}
												{/strip}</a>
											{/if}
										</td>
										<td class="txt normal">
											{if !$comment.delete_date && $comment.has_attachment}
												ファイル:<strong><a href="/UserIdea/Export/{$comment.id}?name=attachment">{$comment.name}</a></strong>
												({$comment.attachment.size|binary_size_format}B)
											{/if}
										</td>
										<td valign="bottom" class="reComment">
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	{/foreach}
</div>

{form action='Comment'}
	<div align="center">
		<textarea name="body" cols="48" rows="5" class="input04" style="width:520px"></textarea><br/>
		<input type="submit" value="送信" />
	</div>
{/form}

{* vim: set tabstop=4: *}
