{*
@package jp.co.commons.cfms
@subpackage UserAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
*}

{foreach from=$accounts key='id' item='account'}
	<table cellspacing="0" cellpadding="0">
		<tr>
			<th valign="top" scope="row">
				{if $account.has_icon}
					{image_cache class='Account' id=$account.id size='icon' pixel=60}
				{else}
					<img src="/images/project_thumbnail01.gif" width="60" height="60" alt="{$account.company} {$account.name}様">
				{/if}
			</th>
			<td valign="top">{strip}
				<strong>
					{$account.company}<br>
					{$account.name}様
				</strong>
			{/strip}</td>
		</tr>
	</table>
{/foreach}

{* vim: set tabstop=4: *}
