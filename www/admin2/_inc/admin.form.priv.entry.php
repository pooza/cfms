<?php
/*
����	���̏��ނ� project.php �� user_proj ���[�h�Ŏg���Ă��邪�A�s�K�؁B	����
����	SQL�Ȃǂ� project.php ���Ŏ��s���A�����͕\�����邾���ɂ������B				����
����	�܂��A���ޖ����iform�ł͂Ȃ��̂Łj���K�؂Ȗ��O�ɒ��������B					����
*/


// SQL
// -----------------------------------------------------------------------------
		$sql	=	"select project.id, project.name, project.owner as owner,count(priv.user_id) as users "
					.	"from project,priv "
					.	"where project.id = priv.project_id "
					.	"and user_id='$tid' "
					.	"group by priv.project_id";

		$Rslt	=	fcn_sql_exec ($con,$sql);
		$rows	= mysql_num_rows ($Rslt);	// �\���A�C�e����
// -----------------------------------------------------------------------------


// �Č����X�g�̕\��
// -----------------------------------------------------------------------------
		if($rows==0){
			error("���[�U�u<font color='red'>$user_name</font>�v�͂ǂ̈Č��ɂ��֌W���Ă��܂���B","back");
		}else{
			// print "<hr width='100%' size='1' color='#dcdcdc' noshade>\n";	//���� �Ӗ����킩��Ȃ�
			// spacer(5);
			print "<div class='plain'>���[�U�u&nbsp;<font color='red'>$user_name</font>&nbsp;�v��&nbsp;"
					.	"<font color='red'>$rows</font>&nbsp;���̈Č��Ɋ֌W���Ă��܂��B</div>\n";
			spacer(15);
?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='#cccccc'>
<tr bgcolor='#ccccff'>
<td class='plain'>ID</td>
<td class='plain'>�Č���</td>
<td class='plain'>�I�[�i�[</td>
</tr>
<?		while ($Rec = mysql_fetch_array($Rslt)){
				$owner	=	fcn_sql_sa("select name from user where id='$Rec[owner]'");

				$HTML[]	= "<tr bgcolor='#ffffff'>";
				$HTML[]	= "<td class='caption'>".	$Rec[id]			."</td>";
				$HTML[]	= "<td class='plain'>".		$Rec[name]		."</td>";
				$HTML[]	= "<td class='plain'>".		$owner				."</td>";
				$HTML[]	= "</tr>";

				print implode("\n",$HTML);
				unset($HTML);
			}	?>
</table>
<?	}
		
		spacer(10);
// ----------------------------------------------------------------------------


?>