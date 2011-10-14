<?php
	require_once("carrotlib/php/cfms1/_def.inc");

	if (!DEBUG && ($_SERVER["HTTPS"] != "on")) {
		header("Location: " . ROOT_URL);
		exit();
	}

	include("_header.inc");
?>

<div align='center'>
	<h2><?= APP_NAME ?><br><small>Ver.<?= APP_VER ?></small></h2>
	<img src='carrotlib/images/cfms1/_spacer.gif' height='100' width='100'><br>
	<form action='auth.php' method='post'>
		<table class='white' border='0' cellspacing='0' cellpadding='4'>
			<tr height='28'>
				<td class='mono' width='120' height='28'>メールアドレス</td>
				<td width='220' height='28'>
					<input type='text' name='user' size='32'>
				</td>
			</tr>
			<tr height='28'>
				<td class='mono' width='120' height='28'>パスワード</td>
				<td width='220' height='28'>
					<input type='password' name='password' size='16'>
				</td>
			</tr>
			<tr height='28'>
				<td colspan='2' align='center'>
					<input type='submit' value='ログイン'>
				</td>
			</tr>
		</table>
	</form>
	<img src='carrotlib/images/cfms1/_spacer.gif' height='60' width='100'><br>
	<script language='JavaScript' type='text/javascript' src='//smarticon.geotrust.com/si.js'></script><br><br>
	<img src='carrotlib/images/cfms1/logo.gif' border='0'>
</div>

<?php
	include("_footer.inc");
?>
