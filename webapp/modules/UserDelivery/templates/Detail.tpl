{*
ファイル登録画面テンプレート

@package jp.co.commons.cfms
@subpackage UserDelivery
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta name="Description" content="">
		<meta name="Keywords" content="">
		<title>COMMONS FILE DELIVERY beta - {$delivery.filename}</title>
		<link rel="stylesheet" type="text/css" href="/carrotlib/css/delivery/base.css" media="all">
		<link rel="stylesheet" type="text/css" href="/carrotlib/css/delivery/layout.css" media="all">
		<link rel="stylesheet" type="text/css" href="/carrotlib/css/delivery/style.css" media="all">
		<script type="text/javascript" src="/common/js/mjl.js"></script>
		<script type="text/javascript" src="/common/js/run.js"></script>
		<script type="text/javascript" src="/common/js/common.js"></script>
	</head>
	<body id="sec" class="delivery_user">
		<a name="pagetop" id="pagetop"></a>
		<div id="wrapper"><!-- HEADER -->
			<div id="header">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td class="title">
							<h1><img src="/images/h1-logo02.gif" width="289" height="53" alt="COMMONS"></h1>
						</td>
						<td class="head_txt h2_txt">
							<h2><img src="/images/header_txt.gif" width="253" height="34" alt="FILE DELIVERY"></h2>
						</td>
						<td class="head_txt p_txt">
							<p><img src="/images/header_txt_beta.gif" width="42" height="17" alt="beta"></p>
						</td>
					</tr>
				</table>
			</div>
			<!-- //HEADER -->
			<!-- CONTENTS -->
			<div id="container">
				<p class="large user_name"><strong>{$delivery.recipient}&nbsp;様</strong></p>
				<p class="normal"><strong>コモンズ株式会社&nbsp;{$delivery.account.name}&nbsp;が下記ファイルをアップしました。</strong></p>
				<div class="file_box">
					<dl>
						<dt><img src="/images/filename_icon.gif" width="113" height="34" alt="ファイル名">
						</dt>
						<dd>
							<p class="medium"><strong>{$delivery.filename}</strong></p>
						</dd>
						<dt><img src="/images/filecapacity_icon.gif" width="113" height="34" alt="ファイル容量">
						</dt>
						<dd>
							<p class="medium"><strong>{$delivery.attachment.size|binary_size_format}B</strong></p>
						</dd>
						<dt><img src="/images/save_icon.gif" width="113" height="34" alt="保存期限">
						</dt>
						<dd>
							<p class="medium">{$delivery.expire_date|date_format:'Y年m月d日 H:i:s'}　までダウンロード可能です。</p>
						</dd>
					</dl>
				</div>
				<div class="comment_box_top">
					<div class="comment_box_footer">
						<p class="normal">{$delivery.comment|nl2br|default:'(空欄)'}</p>
					</div>
				</div>
				<div class="form_box02">
					{form onsubmit=''}
						<table border="0" cellspacing="4" cellpadding="0">
							<input type="hidden" name="t" value="{$params.t}">
							<tr>
								<th class="normal form_text">
									<p><strong>ダウンロードパスワード</strong></p>
								</th>
								<td class="b_none">
									<input type="password" name="password" class="input02" autocomplete="off" /><br/>
									<span class="alert">{$errors.comment}</span>
								</td>
							</tr>
							<tr>
								<th class="back_none">&nbsp;</th>
								<td class="b_none">
									<p class="medium"><span class="red_font">※メールでご案内しているダウンロードパスワードをご記入ください。</span></p>
								</td>
							</tr>
						</table>
						<input type="image" src="/images/download_btn.gif" alt="更新" value="更新" class="inputbtn">
					{/form}
				</div>
				<div class="banner">
					<script language='JavaScript' type='text/javascript' src='//smarticon.geotrust.com/si.js'></script>
				</div>
				{form action='Thanx'}
					<div class="completion">
						<p class="large"><strong><span class="green_icon">■</span>完了通知</strong></p>
						<p class="medium read_txt">ファイルを受け取ることができましたら、このボタンを押してください。</p>
						<p>
							<input type="image" src="/images/completion_btn.gif" width="194" height="53" alt="完了通知">
						</p>
					</div>
				{/form}
			</div>
			<!-- FOOTER -->
			<div id="footer" class="alignR">
			</div>
			<!-- //FOOTER -->
		</div>
		<!-- //CONTENTS -->
	</body>
</html>

{* vim: set tabstop=4: *}
