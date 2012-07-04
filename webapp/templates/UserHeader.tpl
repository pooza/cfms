{*
ユーザー画面 テンプレートひな形

@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{const name='APP_NAME_JA'}</title>
{js_cache name=$jsset|default:'user'}
{if $module.name=='UserDelivery'}
  {css_cache name='delivery'}
{else}
  {css_cache name=$theme.name|default:'default'}
  {css_cache name='glider'}
{/if}
</head>
<body id="{$body.id}" class="{$body.class}">
<a name="pagetop" id="pagetop"></a>
<div id="wrapper">
{* vim: set tabstop=4: *}