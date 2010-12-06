{*
ユーザー画面 テンプレートひな形

@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>{const name='app_name_ja'} {$title|default:$module.title}</title>
{js_cache name=$jsset}
{css_cache name=$theme.name|default:'cfms'}
</head>
<body {if $body.id}id="{$body.id}"{/if}>

<div id="Contents">

<div id="Header">
{const name='app_name_ja'} {$title|default:$module.title}
</div>

{if $menu}
<div id="Menu">
	<ul>
{foreach from=$menu item=item}
	{if $item.separator}
		<li class="separator">&nbsp;</li>
	{elseif $item.href}
		<li><a href="{$item.href}" target="{$item.target|default:'_blank'}">{$item.title}</a></li>
	{else}
		<li><a href="/{$item.module}/{$item.action}">{$item.title}</a></li>
	{/if}
{/foreach}
	</ul>
</div>
<script type="text/javascript">
document.observe('dom:loaded', function () {ldelim}
  new Elevator($('Menu'), 10, 30, 10);
  new PeriodicalExecuter(function () {ldelim}
    new Ajax.Request('/Ping', {ldelim}
      method: 'get'
    {rdelim});
  {rdelim}, 300);
{rdelim});
</script>
{/if}

{* vim: set tabstop=4: *}