{*
ファイル情報メールの文面
 
@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{const name='app_name_ja'}] "{$idea.name}" ({$idea.project.name})
To: {foreach from=$idea.accounts item='account'}{$account.email},{/foreach}


名前: {$idea.name}
名前(英): {$idea.name_en|default:'(空欄)'}
フリガナ: {$idea.name_read|default:'(空欄)'}

本文:
{$idea.body|nl2br|default:'(空欄)'}

フォルダ:
{foreach from=$idea.tags item='tag'}[{$tag.name}] {/foreach}


ファイル:
{$idea.attachment.type} {$idea.attachment.size|binary_size_format}B ({$idea.attachment.size|number_format}B)
{$idea.url}