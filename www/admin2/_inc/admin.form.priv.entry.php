<?php
/*
■■	この書類は project.php の user_proj モードで使われているが、不適切。	■■
■■	SQLなどは project.php 側で実行し、ここは表示するだけにしたい。				■■
■■	また、書類名も（formではないので）より適切な名前に直したい。					■■
*/


// SQL
// -----------------------------------------------------------------------------
		$sql	=	"select project.id, project.name, project.owner as owner,count(priv.user_id) as users "
					.	"from project,priv "
					.	"where project.id = priv.project_id "
					.	"and user_id='$tid' "
					.	"group by priv.project_id";

		$Rslt	=	fcn_sql_exec ($con,$sql);
		$rows	= mysql_num_rows ($Rslt);	// 表示アイテム数
// -----------------------------------------------------------------------------


// 案件リストの表示
// -----------------------------------------------------------------------------
		if($rows==0){
			error("ユーザ「<font color='red'>$user_name</font>」はどの案件にも関係していません。","back");
		}else{
			// print "<hr width='100%' size='1' color='#dcdcdc' noshade>\n";	//■■ 意味がわからない
			// spacer(5);
			print "<div class='plain'>ユーザ「&nbsp;<font color='red'>$user_name</font>&nbsp;」は&nbsp;"
					.	"<font color='red'>$rows</font>&nbsp;件の案件に関係しています。</div>\n";
			spacer(15);
?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='#cccccc'>
<tr bgcolor='#ccccff'>
<td class='plain'>ID</td>
<td class='plain'>案件名</td>
<td class='plain'>オーナー</td>
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