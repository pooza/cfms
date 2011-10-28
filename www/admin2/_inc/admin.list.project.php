<?php

switch($_GET['mode']){

	// 案件からユーザを抽出
	case 'proj-user':
	
		$tr_color	=	fcn_list_bgc ($Rec['status']);

		$HTML[]	=	"<tr bgcolor='$tr_color'>";
		$HTML[]	=	"<td><a href='user.php?mode=edit&tid=".$Rec['id']."'>".$Rec['name'].'</a></td>';
		$HTML[]	=	"<td class='plain'>".		$Rec['id']			.'</td>';
		$HTML[]	=	"<td class='plain'>".		$Rec['pw']			.'</td>';
		$HTML[]	=	"<td class='plain'>".		$Rec['company']	.'</td>';
		$HTML[]	=	"<td class='gray'>[<a href='$PHP_SELF?mode=user-proj&tid=$Rec[id]'>案件</a>]</td>";
		$HTML[]	=	"<td class='gray'>[<a href='$PHP_SELF?mode=user-info&tid=$Rec[id]'>案内</a>]</td>";
		$HTML[]	=	"</tr>";
		break;

	// ユーザから案件を抽出
	case 'user-proj':
	
		$owner	=	fcn_sql_sa("select name from user where id='$Rec[owner]'");
		$HTML[]	= "<tr bgcolor='#ffffff'>";
		$HTML[]	= "<td class='caption'>".	$Rec['id'].$tr_color		.'</td>';
		$HTML[]	= "<td class='plain'>".		$Rec['pw']		.'</td>';
		$HTML[]	= "<td class='plain'>".		$owner				.'</td>';
		$HTML[]	= "</tr>";
		break;

	// デフォルト
	default:
	
		$tr_color	=	fcn_list_bgc ($Rec['status']);

		$owner	=	fcn_sql_sa("select name from user where id='$Rec[owner]'");
		$HTML[]	= "<tr bgcolor='$tr_color'>";
		$HTML[]	= "<td class='caption'>".	$Rec['id']			.'</td>';
		$HTML[]	= "<td class='plain'>".		$Rec['name']		.'</td>';
		$HTML[]	= "<td class='plain'>".		$owner					.'</td>';
		$HTML[]	= "<td class='caption'>".	$Rec['a_date']	.'</td>';
		$HTML[]	= "<td align='right'><span class='plain'>"
						.	"<a href='$PHP_SELF?mode=proj-user&tid=$Rec[id]'>$Rec[users]人</a>"
						.	"</span></td>";
		$HTML[]	= "</tr>";
		break;

}

// 出力
print implode("\n",$HTML);
unset($HTML);

?>