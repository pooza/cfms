{*
ファイル情報メールの文面
 
@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{const name='app_name_ja'}] "{$delivery.filename}"
From: {$delivery.account.email}
To: {$delivery.email}


{$delivery.account.company} {$delivery.account.name} が
「{$delivery.filename}」を
アップいたしました。ご確認ください。


■COMMONS FILE DELIVERY (beta)
{$delivery.url}?t={$delivery.token}
{$delivery.attachment.size|binary_size_format}B ({$delivery.attachment.size|number_format}B)


■ダウンロードパスワード
{$params.password}


■本文:
{$delivery.comment|default:'(空欄)'}


[{const name='app_name_ja'}] {const name='app_ver'}
