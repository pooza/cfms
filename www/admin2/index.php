<?php

// 起動 ------------------------------------------
		require_once ('xdef.admin.inc');
		$con = fcn_db_connect();
// ----------------------------------------------


		if(isset($_POST[ui_btn_login])){
			if($_POST['id']==_ADM_NAME_S_ && $_POST['pw']==_ADM_PASS_){
	
				// Cookie発行
				setcookie('cfms_admin2[login]','ok',0);

				header('Location: project.php?mode=list');
			}
		}


		include_once ('_header.admin.php');
?>
<body>

<table cellspacing='0' cellpadding='0' border='0'>
<tr>
<td valign='top' width='10'></td>
<td valign='top'>

<div class='function'><?=_APP_NAME_?>&nbsp;TOP</div>
<img src='images/_spacer.gif' width='100' height='30'><br>

<form action='index.php' method='post'>
<table class='white' border='0' cellspacing='0' cellpadding='8'>
<tr>
<td class='mono'>ID:</td>
<td><input type='text' name='id' size='16'></td>
</tr>
<tr>
<td class='mono'>PW:</td>
<td><input type='password' name='pw' size='16'></td>
</tr>
<tr>
<td colspan='2' align='right'><input type='submit' name='ui_btn_login' value='ログイン'></td>
</tr>
</table>
</form>

</td>
</tr>
</table>

<?
//■ フッタ出力
// -----------------------------------------------------------------------------
		include_once('_footer.admin.php');
// -----------------------------------------------------------------------------
?>