<?php

switch($_GET['mode']){

	// �Č����烆�[�U�𒊏o
	case 'proj-user':
	
		$tr_color	=	fcn_list_bgc ($Rec['status']);

		$HTML[]	=	"<tr bgcolor='$tr_color'>";
		$HTML[]	=	"<td><a href='user.php?mode=edit&tid=".$Rec['id']."'>".$Rec['name'].'</a></td>';
		$HTML[]	=	"<td class='plain'>".		$Rec['id']			.'</td>';
		$HTML[]	=	"<td class='plain'>".		$Rec['pw']			.'</td>';
		$HTML[]	=	"<td class='plain'>".		$Rec['company']	.'</td>';
		$HTML[]	=	"<td class='gray'>[<a href='$PHP_SELF?mode=user-proj&tid=$Rec[id]'>�Č�</a>]</td>";
		$HTML[]	=	"<td class='gray'>[<a href='$PHP_SELF?mode=user-info&tid=$Rec[id]'>�ē�</a>]</td>";
		$HTML[]	=	"</tr>";
		break;

	// ���[�U����Č��𒊏o
	case 'user-proj':
	
		$owner	=	fcn_sql_sa("select name from user where id='$Rec[owner]'");
		$HTML[]	= "<tr bgcolor='#ffffff'>";
		$HTML[]	= "<td class='caption'>".	$Rec['id'].$tr_color		.'</td>';
		$HTML[]	= "<td class='plain'>".		$Rec['pw']		.'</td>';
		$HTML[]	= "<td class='plain'>".		$owner				.'</td>';
		$HTML[]	= "</tr>";
		break;

	// �f�t�H���g
	default:
	
		$tr_color	=	fcn_list_bgc ($Rec['status']);

		$owner	=	fcn_sql_sa("select name from user where id='$Rec[owner]'");
		$HTML[]	= "<tr bgcolor='$tr_color'>";
		$HTML[]	= "<td class='caption'>".	$Rec['id']			.'</td>';
		$HTML[]	= "<td class='plain'>".		$Rec['name']		.'</td>';
		$HTML[]	= "<td class='plain'>".		$owner					.'</td>';
		$HTML[]	= "<td class='caption'>".	$Rec['a_date']	.'</td>';
		$HTML[]	= "<td align='right'><span class='plain'>"
						.	"<a href='$PHP_SELF?mode=proj-user&tid=$Rec[id]'>$Rec[users]�l</a>"
						.	"</span></td>";
		$HTML[]	= "</tr>";
		break;

}

// �o��
print implode("\n",$HTML);
unset($HTML);

?>