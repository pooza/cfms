{*
ユーザー画面 テンプレートひな形

@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="Description" content="">
<meta name="Keywords" content="">
<title>{const name='APP_NAME_JA'}</title>
{js_cache name=$jsset|default:'user'}
{css_cache name=$theme.name|default:'default'}
{css_cache name='glider'}
</head>
<body id="{$body.id}" class="{$body.class}">
<a name="pagetop" id="pagetop"></a>
<div id="wrapper">
{* vim: set tabstop=4: *}