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
					{image_cache src='profile_noicon.gif' dir='local_images'}
				{/if}
			</th>
			<td valign="top" class="small">{strip}
				{$account.company}<br>
				{$account.name}{if $account.type!='commons'}様{/if}
			{/strip}</td>
		</tr>
	</table>
{/foreach}

{* vim: set tabstop=4: *}
