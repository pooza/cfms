<?php

//■ 起動
// -----------------------------------------------------------------------------
		require_once('xdef.admin.inc');
		// fcn_basic_auth();
		$con = fcn_db_connect();
// -----------------------------------------------------------------------------


// アクセス制限
		if(!isset($_COOKIE['cfms_admin2']))	error('不正なアクセスです。','close');


		fcn_header_admin ('管理ログ');


		if(isset($_POST['lognum']) && !empty($_POST['lognum'])){
			$num	=	intval(trim($_POST['lognum']));
		}else{
			$num	=	30;
		}


		$sql	=	"select * from log_system order by id desc limit $num";
		$Rslt	=	fcn_sql_exec ($con,$sql);
		$rows	= mysql_num_rows ($Rslt);
?>
<form action='<?=$PHP_SELF?>' method='POST' name='ui_form_syslog'>
<input type='text' name='lognum' size='10'><input type='submit' name='ui_btn_syslog' value='設定'>
</form>

<img src='images/_spacer.gif' width='100' height='20'><br>

<table cellspacing='1' cellpadding='2' border='0' bgcolor='#cccccc'>
<tr bgcolor='skyblue'>
<td class='plain'>ID</td>
<td class='plain'>log_date</td>
<td class='plain'>lv</td>
<td class='plain'>description</td>
<td class='plain'>remote_addr</td>
<td class='plain'>remote_host</td>
<td class='plain'>script</td>
</tr>
<?	while ($Rec = mysql_fetch_array($Rslt)){?>
<tr bgcolor='#ffffff'>
<td class='caption'><?=$Rec['id']?></td>
<td class='caption'><?=fcn_datetime_cvt ($Rec['log_date'],'default')?></td>
<td class='caption'><?=$Rec['error_level']?></td>
<td class='caption'><?=$Rec['description']?></td>
<td class='caption'><?=$Rec['remote_addr']?></td>
<td class='caption'><?=$Rec['remote_host']?></td>
<td class='caption'><?=$Rec['script']?></td>
</tr>
<?	}	?>
</table>

</td>
</tr>
</table>

<?
//■ フッタ出力
// -----------------------------------------------------------------------------
		include_once('_footer.admin.php');
// -----------------------------------------------------------------------------
?>