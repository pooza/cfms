{*
ファイル情報メールの文面
 
@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{const name='app_name_ja'}] "{$delivery.filename}"
From: {$delivery.account.email}
To: {$delivery.email}


[{const name='app_name_ja'}] に
「{$delivery.filename}」
がアップされています。ご確認ください。

作成者:
{$delivery.account.company} {$delivery.account.name}

ファイル:
{$delivery.attachment.type} {$delivery.attachment.size|binary_size_format}B ({$delivery.attachment.size|number_format}B)
{$delivery.url}?t={$delivery.token}

本文:
{$delivery.comment|default:'(空欄)'}


[{const name='app_name_ja'}] {const name='app_ver'}
