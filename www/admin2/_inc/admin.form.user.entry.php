<?
if($fcn=="edit" && isset($_GET[tid])){
	$tid	=	trim($_GET[tid]);
	$Rslt	=	fcn_sql_exec($con,"select * from user where id='$tid'");
	$Rec	=	mysql_fetch_array($Rslt);
}
?>

<form action='confirm.php' method='POST' name='form_user_entry'>
<input type='hidden' name='flag' value='<?=$fcn?>'>
<?
if($fcn=="edit"){	?>
<input type='hidden' name='tid' value='<?=$tid?>'>
<?
}
?>
<table cellpadding='4' cellspacing='1' border='0' bgcolor=''>
<?
if($fcn=="edit"){	?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>ID</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='id' size='48' value='<?=$Rec[id]?>'></td>
</tr>
<?
}
?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>����</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='name' size='48'<?
if($fcn=="edit"){print " value='$Rec[name]'";}
?>></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>�����i�p��j</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='name_r' size='48'<?
if($fcn=="edit"){print " value='$Rec[name_read]'";}
?>></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>���[���A�h���X</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='email' size='48'<?
if($fcn=="edit"){print " value='$Rec[email]'";}
?>></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>��Ж�</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='company' size='48'<?
if($fcn=="edit"){print " value='$Rec[company]'";}
?>></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>����</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='section' size='48'<?
if($fcn=="edit"){print " value='$Rec[section]'";}
?>></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>��E</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='title' size='48'<?
if($fcn=="edit"){print " value='$Rec[title]'";}
?>></td>
</tr>
<tr>
<td bgcolor='#98fb98' valign='middle'><span class='plain'>�p�X���[�h</span></td>
<td bgcolor='#fafffa' valign='middle'><input type='text' name='pw' size='48'<?
if($fcn=="edit"){print " value='$Rec[password]'";}
?>></td>
</tr>
<?
if($fcn=="edit"){
	switch($Rec[status]){
		case "SYSTEM":
			$selected1	=	' selected';
			break;
		case "ACTIVE":
			$selected2	=	' selected';
			break;
		case "LEAVE":
			$selected3	=	' selected';
			break;
	}	?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>�X�e�[�^�X</span></td>
<td bgcolor='#fafffa' valign='middle'><select size='1' name='status'>
<option value='SYSTEM'<?=	$selected1	?>>SYSTEM</option>
<option value='ACTIVE'<?=	$selected2	?>>ACTIVE</option>
<option value='LEAVE'<?=	$selected3	?>>LEAVE</option>
</select></td>
</tr>
<?
}
?>
<tr>
<td bgcolor='#98fb98' valign='middle' width='120'><span class='plain'>�Č�</span></td>
<td bgcolor='#fafffa' valign='middle'><?

switch($fcn){
	case "add":
		$user_id	=	$Post[id];	break;
	case "edit":
		$user_id	=	$Rec[id];		break;
}

fcn_make_sel_priv	($con,$fcn,$user_id);
?></td>
</tr>
<tr>
<td colspan='2' align='right'>
<input type='submit' name='btn_user_entry' value='���̃��[�U��o�^'><br>
</td>
</tr>
</table>

</form>
