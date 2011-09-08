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
					<tr>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
					</tr>
					<tr>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">LOREAL</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">GOLDWIN</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">melvita</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">JAL</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">kraft</a></p>
						</td>
					</tr>
					<tr class="door_mt">
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
						<td width="162"><a href="project.html"><img src="/images/door_img.gif" width="68" height="113" alt=""></a></td>
					</tr>
					<tr>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">LOREAL</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">GOLDWIN</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">melvita</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">JAL</a></p>
						</td>
						<td class="door_text">
							<p class="normal text_l"><a href="project.html">kraft</a></p>
						</td>
					</tr>
				</table>
			</td>
			<td class="icon_img"><a href="#"><img src="/images/door_icon_right.gif" width="16" height="61" alt=""></a></td>
		</tr>
	</table>
</div>

{*
<div id="BreadCrumbs">
	<a href="#">プロジェクト一覧</a>
</div>

{form method="get" style_class='common_block'}
	<input type="text" name="key" value="{$params.key}" />
	<input type="submit" value="抽出" />
	<input type="button" value="抽出の解除" onclick="CarrotLib.redirect('{$module.name}','ListAll')" />
{/form}

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="32"></th>
		<th width="300">名前</th>
		<th width="180">期間</th>
	</tr>

{foreach from=$projects item='project'}
	<tr class="{$project.status}">
		<td width="32" align="center">{image_cache id=$project.id size='logo' pixel=32}</td>
		<td width="300"><a href="/{$module.name}/Wall/{$project.id}">{$project.name}</a></td>
		<td width="180" align="center">
			{if $project.start_date||$project.end_date}
				{$project.start_date|date_format:'Y.m.d'}～{$project.end_date|date_format:'Y.m.d'}
			{/if}
		</td>
	</tr>
{/foreach}

</table>
*}

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
