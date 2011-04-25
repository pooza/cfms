{*
@package jp.co.commons.cfms
@subpackage UserAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
*}

{foreach from=$accounts key='id' item='account'}
	<div>
		{image_cache class='Account' id=$account.id size='icon' pixel=16}
		{$account.company}
		{$account.name}
	</div>
{/foreach}

{* vim: set tabstop=4: *}
