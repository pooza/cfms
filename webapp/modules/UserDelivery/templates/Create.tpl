{*
ファイル登録画面テンプレート

@package jp.co.commons.cfms
@subpackage UserDelivery
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
		<meta name="Description" content="">
		<meta name="Keywords" content="">
		<title>COMMONS TABLE</title>
		<link rel="stylesheet" type="text/css" href="/carrotlib/css/delivery/base.css" media="all">
		<link rel="stylesheet" type="text/css" href="/carrotlib/css/delivery/layout.css" media="all">
		<link rel="stylesheet" type="text/css" href="/carrotlib/css/delivery/style.css" media="all"><script type="text/javascript" src="/common/js/mjl.js"></script><script type="text/javascript" src="/common/js/run.js"></script><script type="text/javascript" src="/common/js/common.js"></script>
	</head>
	<body id="sec" class="delivery">
		<a name="pagetop" id="pagetop"></a>
		<div id="wrapper"><!-- HEADER -->
			<div id="header">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td class="title">
							<h1><img src="/images/common/h1-logo.gif" width="335" height="37" alt="COMMONS TABLE"></h1>
						</td>
						<td class="gl-menu">
							<table cellspacing="0" cellpadding="0" class="roll">
								<tr>
									<td><a href="/UserDelivery/Create"><img src="/images/common/gl-menu04_on.gif" width="70" height="71" alt="DELIVERY" class="unroll"></a></td>
									<td class="sp">&nbsp;</td>
									<td><a href="/UserProject/"><img src="/images/common/gl-menu01.gif" width="70" height="71" alt="PROJECT"></a></td>
									<td class="sp">&nbsp;</td>
									<td><a href="/UserAccount/"><img src="/images/common/gl-menu02.gif" width="71" height="71" alt="PROFILE"></a></td>
									<td class="sp">&nbsp;</td>
									<td><a href="/Logout"><img src="/images/common/gl-menu03.gif" width="71" height="71" alt="LOGOUT"></a></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<!-- //HEADER -->
			<!-- CONTENTS -->
			<div id="container">
				<h2 class="delivery_img large"><img src="/images/delivery_textimg.gif" width="147" height="29" alt="DELIVERY"><br>
					<strong>誰にでもファイルを送ることができます。</strong>
				</h2>
				{include file='ErrorMessages'}
				{form attachable=true}
					<div class="form_box03">
						<div class="destination">
							<h4 class="large"><strong><span class="green_icon">■</span>宛先</strong>
							</h4>
							<table border="0" cellspacing="4" cellpadding="0">
								<tr>
									<th class="large form_text">
										<p><strong>お名前</strong></p>
									</th>
									<td>
										<input type="text" name="recipient" value="{$params.recipient}" maxlength="64" class="input01" />
									</td>
								</tr>
								<tr>
									<th class="normal form_text">
										<p><strong>メールアドレス</strong></p>
									</th>
									<td class="b_none">
										<input type="text" name="email" value="{$params.email}" maxlength="64" class="input02" />
									</td>
								</tr>
							</table>
						</div>
						<div class="file_box">
							<h4 class="large"><strong><span class="green_icon">■</span>ファイル</strong>
							</h4>
							<table border="0" cellspacing="4" cellpadding="0">
								<tr>
									<th class="normal form_text">
										<p><strong>ファイル選択</strong></p>
									</th>
									<td>
										<input type="file" name="attachment" size="20" class="green_solid" />
									</td>
								</tr>
								<tr>
									<th class="normal form_text">
										<p><strong>保存期間</strong></p>
									</th>
									<td>{html_radios name='preserve_duration' options=$duration_options selected=$params.preserve_duration}</td>
								</tr>
								<tr>
									<th class="normal form_text">
										<p><strong>パスワード設定</strong></p>
									</th>
									<td>
										<input type="password" name="password" value="{$params.password}" maxlength="64" class="input01" />
									</td>
								</tr>
								<tr>
									<th class="normal form_text comment_box01">
										<p><strong>コメント</strong></p>
									</th>
									<td class="b_none">
										<textarea name="comment" cols="60" rows="10" class="input03" />{$params.comment}</textarea>
									</td>
								</tr>
							</table>
							<input type="image" src="/images/send_btn.gif" alt="送信" value="送信" class="inputbtn">
						</div>
					</div>
				{/form}
				{if $deliveries}
					<div class="transmission">
						<h4 class="large"><strong><span class="green_icon">■</span>送信履歴</strong></h4>
						<table width="0" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th class="normal time"><strong>日時</strong></th>
								<th class="normal name"><strong>宛先</strong></th>
								<th class="normal file_name"><strong>ファイル名</strong></th>
							</tr>
							{foreach from=$deliveries item='delivery'}
								<tr>
									<td class="normal">{$delivery.create_date|date_format:'Y年m月d日 H:i:s'}</td>
									<td class="normal">{$delivery.recipient}</td>
									<td class="normal">
										{$delivery.filename}
										[<a href="javascript:void(CarrotLib.confirmDelete('UserDelivery','Delete','デリバリー',{$delivery.id}))">削除</a>]
									</td>
								</tr>
							{/foreach}
						</table>
					</div>
				{/if}
			</div>
			<!-- FOOTER -->
			<div id="footer" class="alignR"><script type="text/javascript">
<!--
	secFooter('');
//--> </script>
			</div>
			<!-- //FOOTER -->
		</div>
		<!-- //CONTENTS -->
	</body>
</html>

{*
	<table border="1">
		<tr>
			<th>日時</th>
			<th>宛先</th>
			<th>ファイル名</th>
			<th></th>
		</tr>
		{foreach from=$deliveries item='delivery'}
			<tr>
				<td>{$delivery.create_date}</td>
				<td>{$delivery.recipient}</td>
				<td>{$delivery.filename}</td>
				<td>
					[<a href="javascript:void(CarrotLib.confirmDelete('UserDelivery','Delete','デリバリー',{$delivery.id}))">削除</a>]
				</td>
			</tr>
		{/foreach}
	</table>
</div>
*}

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
