
<form action='user.php' method='POST' name='form_user_entry'>
<input type='hidden' name='flag' value='<?=$fcn?>'>
<input type='hidden' name='name' size='48' value='<?=$Post[name]?>'>
<input type='hidden' name='name_r' size='48' value='<?=$Post[name_r]?>'>
<input type='hidden' name='email' size='48' value='<?=$Post[email]?>'>
<input type='hidden' name='company' size='48' value='<?=$Post[company]?>'>
<input type='hidden' name='section' size='48' value='<?=$Post[section]?>'>
<input type='hidden' name='title' size='48' value='<?=$Post[title]?>'>
<input type='hidden' name='pw' size='48' value='<?=$Post[pw]?>'>
<input type='hidden' name='priv' size='48' value='<?=$priv?>'>
<?	if($fcn=="edit"){	?>
<input type='hidden' name='tid' size='48' value='<?=$tid?>'>
<input type='hidden' name='id' size='48' value='<?=$Post[id]?>'>
<input type='hidden' name='status' size='48' value='<?=$Post[status]?>'>
<?	}	?>

<table cellspacing='1' cellpadding='8' border='0' bgcolor=''>
<?	if($fcn=="edit"){	?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>ID</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[id]?></td>
</tr>
<?	}	?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>氏名</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[name]?></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>氏名（英語）</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[name_r]?></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>メールアドレス</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[email]?></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>会社名</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[company]?></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>部署</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[section]?></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>役職</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[title]?></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>パスワード</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[pw]?></td>
</tr>
<?	if($fcn=="edit"){	?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>ステータス</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?=$Post[status]?></td>
</tr>
<?	}	?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>案件</span></td>
<td bgcolor='#e0ffff' valign='middle' class='plain'><?

// 案件リストの表示
// -----------------------------------------------------------------------------
		if($priv =='NULL' || $Post['status'] =='LEAVE'){
			print "このユーザはどの案件にもアサインされていません。";
		}else{
			$Priv	=	explode("/",$priv);	?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='gray'>
<?		foreach ($Priv as $key => $value){	?>
<tr>
<td bgcolor='#e0ffff' class='plain'><?=	$Priv[$key]	?></td>
<td bgcolor='#e0ffff' class='plain'><?=	fcn_sql_sa("select name from project where id=".$Priv[$key]);	?></td>
</tr>			
<?		}	?>
</table>	
<?	}
// ----------------------------------------------------------------------------

?></td>
</tr>
<tr>
<td colspan='2' align='right'>
<img src='images/_spacer.gif' width='100%' height='6'><br>
<input type='submit' name='btn_user_confirm' value='この内容でユーザを登録'><br>
<img src='images/_spacer.gif' width='100%' height='10'><br>
<span class='gray'>[<a href='Javascript:history.back()'>前の画面に戻る</a>]</span>
</td>
</tr>
</table>

</form>
