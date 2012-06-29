{*
アカウント登録画面テンプレート

@package jp.co.commons.cfms
@subpackage AdminAccount
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='AdminHeader'}

<nav class="bread_crumbs">
  <a href="/{$module.name}/">{$module.record_class|translate}一覧</a>
  <a href="#">{$action.title}</a>
</nav>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form attachable=true}
  <table class="detail">
    <tr>
      <th>名前</th>
      <td>
        <input type="text" name="name" value="{$params.name}" size="40" maxlength="64">
      </td>
    </tr>
    <tr>
      <th>会社</th>
      <td>
        <input type="text" name="company" value="{$params.company}" size="40" maxlength="64">
      </td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td>
        <input type="text" name="email" value="{$params.email}" size="40" maxlength="64" class="english">
      </td>
    </tr>
    <tr>
      <th>パスワード</th>
      <td>
        <input type="password" name="password" size="20"><br>
        <input type="password" name="password_confirm" size="20">(確認)<br>
      </td>
    </tr>
    <tr>
      <th>アイコン</th>
      <td>
        <input type="file" name="icon" size="20"><br>
      </td>
    </tr>
    <tr>
      <th>種類</th>
      <td>
        {html_radios name='type' options=$type_options selected=$params.type}
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
        <input type="submit" value="登録">
      </td>
    </tr>
  </table>
{/form}

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
