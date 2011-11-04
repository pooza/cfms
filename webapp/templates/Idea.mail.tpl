{*
ファイル情報メールの文面
 
@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{const name='app_name_ja'}] "{$idea.name|default:'(空欄)'}" ({$idea.project.name})
From: {$sender.email}
To: {foreach from=$idea.accounts item='account'}{$account.email},{/foreach}


[{const name='app_name_ja'}] に
「{$idea.name|default:'(空欄)'}」
がアップされています。ご確認ください。

プロジェクト名:
{$idea.project.name}

フォルダ:
{foreach from=$idea.tags item='tag'}[{$tag.name}] {/foreach}


作成者:
{$idea.account.company} {$idea.account.name}

ファイル:
{$idea.attachment.type} {$idea.attachment.size|binary_size_format}B ({$idea.attachment.size|number_format}B)
{$idea.url}

本文:
{$idea.body|default:'(空欄)'}


[{const name='app_name_ja'}] {const name='app_ver'}
