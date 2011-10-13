{*
ファイル情報メールの文面
 
@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{const name='app_name_ja'}] "{$idea.name|default:'(空欄)'}" ({$idea.project.name})
To: {foreach from=$idea.accounts item='account'}{$account.email},{/foreach}


名前: {$idea.name|default:'(空欄)'}

本文:
{$idea.body|nl2br|default:'(空欄)'}

フォルダ:
{foreach from=$idea.tags item='tag'}[{$tag.name}] {/foreach}

作成者:
{$idea.account.company} {$idea.account.name}

ファイル:
{$idea.attachment.type} {$idea.attachment.size|binary_size_format}B ({$idea.attachment.size|number_format}B)
{$idea.url}