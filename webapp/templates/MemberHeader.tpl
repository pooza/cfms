{*
ユーザー画面 テンプレートひな形

@package jp.co.commons.cfms
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<div id="header">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td class="title">
				<h1><img src="/images/common/h1-logo.gif" width="335" height="37" alt="COMMONS TABLE"></h1>
			</td>
			<td class="gl-menu">
				<table cellspacing="0" cellpadding="0" class="roll">
					<tr>
						<td><a href="/UserProject/"><img src="/images/common/gl-menu01_on.gif" width="70" height="71" alt="PROJECT" class="{$links.project.class}"></a></td>
						<td class="sp">&nbsp;</td>
						<td><a href="/UserAccount/"><img src="/images/common/gl-menu02.gif" width="71" height="71" alt="PROFILE" class="{$links.profile.class}"></a></td>
						<td class="sp">&nbsp;</td>
						<td><a href="/Logout"><img src="/images/common/gl-menu03.gif" width="71" height="71" alt="LOGOUT"></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
{* vim: set tabstop=4: *}