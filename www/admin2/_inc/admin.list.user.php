<?php


// �L�[���[�h�̒���
// -----------------------------------------------------------------------------
		$keyword	= strip_tags	($keyword);
		$keyword 	= stripslashes($keyword);
		$keyword 	= str_replace	("'","\'",$keyword);
// -----------------------------------------------------------------------------


// SQL
// -----------------------------------------------------------------------------
		$sql	=	"select * from user "
					. "where "
					.	"id"				." like '%$keyword%' or "
					.	"password"	." like '%$keyword%' or "
					.	"name"			." like '%$keyword%' or "
					.	"name_read"	." like '%$keyword%' or "
					.	"email"			." like '%$keyword%' or "
					.	"company"		." like '%$keyword%' or "
					.	"section"		." like '%$keyword%' or "
					.	"title"			." like '%$keyword%' "
					.	"order by id";

		$Rslt	=	fcn_sql_exec($con,$sql);
		$rows	= mysql_num_rows($Rslt);	// �\���A�C�e����
// -----------------------------------------------------------------------------


// �������ʂ̕\��
// -----------------------------------------------------------------------------
		print "<div class='plain'>"
				.	"�L�[���[�h�u&nbsp;<font color='red'>".$keyword."</font>&nbsp;�v�̌�������"
				.	"</div>\n";
		spacer(10);

		if($rows==0){
			print "<div class='notice'>�L�[���[�h�Ƀ}�b�`���郆�[�U�����܂���ł����B</div>\n";
		}else{
?>
<form action='<?=$PHP_SELF?>?mode=delete' method='POST' name='form_del'>
<table cellspacing='1' cellpadding='2' border='0' bgcolor='#cccccc'>
<tr bgcolor='skyblue'>
<td class='plain'>ID</td>
<td class='plain'>���O</td>
<td class='plain'>E-mail</td>
<td class='plain'>����</td>
<td class='plain'>�p�X���[�h</td>
<td class='plain'>�Č�</td>
<td class='plain'>�ē�</td>
</tr>
<?		while ($Rec = mysql_fetch_array($Rslt)){	?>
<tr bgcolor='<?
				switch($Rec[status]){
					case "LEAVE":	print "#dddddd";	break;
					default:			print "#ffffff";	break;
				}
?>'>
<td class='plain'><?=$Rec[id]?></td>
<td class='plain'><?
				print "<a href='$PHP_SELF?mode=edit&tid=$Rec[id]' title='$Rec[name]($Rec[name_read])�̏���ҏW'>"
						.	$Rec[name]."</a>";
?></td>
<td class='plain'><?=$Rec[email]?></td>
<td class='plain'><?
				if(empty($Rec[section])){
					print $Rec[company];
				}else{
					print $Rec[company]."<br>\n".$Rec[section]."&nbsp;".$Rec[title];
				}
?></td>
<td class='plain'><?=$Rec[password]?></td>
<td class='gray'>[<a href='project.php?mode=user-proj&tid=<?=$Rec[id]?>'>�Č�</a>]</td>
<td class='gray'>[<a href='project.php?mode=user-info&tid=<?=$Rec[id]?>'>�ē�</a>]</td>
</tr>
<?		}	?>
</table>
</form>

</td>
</tr>
</table>

<?	}
// -----------------------------------------------------------------------------
?>