{*
ファイル情報メールの文面
 
@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{const name='app_name_ja'}] "{$delivery.filename}"
From: {const name='admin_email'}
To: {$delivery.account.email}


{$delivery.recipient}さんが
「{$delivery.filename}」
をダウンロードしました。

ファイル:
{$delivery.attachment.type} {$delivery.attachment.size|binary_size_format}B ({$delivery.attachment.size|number_format}B)

本文:
{$delivery.comment|default:'(空欄)'}


[{const name='app_name_ja'}] {const name='app_ver'}
