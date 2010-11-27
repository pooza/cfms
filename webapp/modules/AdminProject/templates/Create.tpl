{*
プロジェクト登録画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminProject
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="/{$module.name}/">{$module.record_class|translate}一覧</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form}
	<table class="detail">
		<tr>
			<th>名前</th>
			<td>
				<input type="text" name="name" value="{$params.name}" size="40" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>名前(英)</th>
			<td>
				<input type="text" name="name_en" value="{$params.name_en}" size="40" maxlength="64" class="english" />
			</td>
		</tr>
		<tr>
			<th>フリガナ</th>
			<td>
				<input type="text" name="name_read" value="{$params.name_read}" size="40" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>期間</th>
			<td>
				<input type="text" id="start_date" name="start_date" value="{$params.start_date|date_format:'Y.m.d'}" size="10" maxlength="10" class="english" /> 〜
				<input type="text" id="end_date" name="end_date" value="{$params.end_date|date_format:'Y.m.d'}" size="10" maxlength="10" class="english" />
			</td>
		</tr>
		<tr>
			<th>状態</th>
			<td>
				{html_radios name='status' options=$status_options selected=$params.status}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="登録" />
			</td>
		</tr>
	</table>
{/form}

<script type="text/javascript">
document.observe('dom:loaded', function () {ldelim}
  new InputCalendar('start_date', {ldelim}
    lang:'ja',
    format:'yyyy.mm.dd'
  {rdelim});
  new InputCalendar('end_date', {ldelim}
    lang:'ja',
    format:'yyyy.mm.dd'
  {rdelim});
{rdelim});
</script>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
