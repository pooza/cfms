{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='door'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<h2 class="large door_text"><strong>ようこそ、{$account.name}様</strong></h2>
	<table width="0" border="0" cellspacing="0" cellpadding="0" class="door_box">
		<tr>
			<td class="icon_img"><a href="#"><img src="/images/door_icon_left.gif" width="16" height="60" alt=""></a></td>
			<td>
				<table width="0" border="0" cellspacing="0" cellpadding="0" class="door01 roll">
					{foreach from=$pages.0 item='row'}
						<tr>
							{foreach from=$row item='project'}
								<td width="162">
									{if $project.id}
										<a href="/UserProject/Wall/{$project.id}"><img src="/images/door_img.gif" width="68" height="113" alt=""></a>
									{/if}
								</td>
							{/foreach}
						</tr>
						<tr>
							{foreach from=$row item='project'}
								<td class="door_text">
									<p class="normal text_l">{strip}
										{if $project.id}
											<a href="/UserProject/Wall/{$project.id}">{$project.name}</a>
										{/if}
									{/strip}</p>
								</td>
							{/foreach}
						</tr>
					{/foreach}
				</table>
			</td>
			<td class="icon_img"><a href="#"><img src="/images/door_icon_right.gif" width="16" height="61" alt=""></a></td>
		</tr>
	</table>
</div>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
