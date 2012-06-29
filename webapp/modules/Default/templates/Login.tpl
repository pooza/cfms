{*
ログイン画面テンプレート

@package jp.co.commons.cfms
@subpackage Default
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='top'}
{include file='UserHeader'}

<div id="header">
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top" class="title">
        <h1><img src="/images/common/h1-logo.gif" width="354" height="37" alt="COMMONS TABLE">
        </h1>
      </td>
      <td valign="top" class="logo">
        <h2><img src="/images/common/commons-logo.gif" width="150" height="37" alt="COMMONS">
        </h2>
      </td>
    </tr>
  </table>
</div>
<div id="container">
  {form}
    <table cellspacing="0" cellpadding="0" class="tbl_login-form">
      <tr>
        <td>
          <table cellspacing="0" cellpadding="0">
            <tr>
              <th class="pad"><img src="/images/top_ttl-id.gif" width="77" height="16" alt="ID（メールアドレス）"></th>
              <td class="pad">
                <input type="text" name="email" value="{$email}" maxlength="64" class="textfield">
              </td>
            </tr>
            <tr>
              <th class="pass"><img src="/images/top_ttl-pass.gif" width="77" height="16" alt="PASS"></th>
              <td>
                <input type="password" name="password" maxlength="64" class="textfield">
              </td>
            </tr>
          </table>
        </td>
        <td class="btn"><input type="image" src="/images/top_bt-login.gif" width="54" height="54" alt="LOGIN"></td>
      </tr>
    </table>
  {/form}
</div>
<div id="footer">
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td class="copyright small">{const name='APP_NAME_JA'} Ver.{const name='APP_VER'} (C)2011 {const name='AUTHOR_NAME_EN'}</td>
      <td class="bnr">
        <script language='JavaScript' type='text/javascript' src='//smarticon.geotrust.com/si.js'></script><br><br>
      </td>
    </tr>
  </table>
</div>

{include file='UserFooter'}

{* vim: set tabstop=4: *}
