
<table width='100%' cellspacing='0' cellpadding='0' border='0'>
<tr>
<td align='right'>
<table cellspacing='0' cellpadding='0' border='0'>
<tr class='gray'>
<?
switch($_GET[mode]){

	//�� ���[�U�o�^���ʂ̕\��
	case "result":
		print "<td class='gray'>[<a href='user.php?mode=list'>���[�U������</a>]</td>\n";
		print "<td width='10'></td>\n";
		print "<td class='gray'>[<a href='user.php?mode=add'>����ɓo�^�𑱂���</a>]</td>\n";
		break;


	//�� ���[�U����Č��𒊏o
	case "user-proj":
		print "<td class='gray'>[<a href='project.php?mode=list'>�Č��ꗗ�ɖ߂�</a>]</td>\n";
		print "<td width='10'></td>\n";
		print "<td class='gray'>[<a href='javascript:history.back()'>�O�̉�ʂɖ߂�</a>]</td>\n";
		break;


	//�� �Č����烆�[�U�𒊏o
	case "proj-user":
		print "<td class='gray'>[<a href='project.php?mode=list'>�Č��ꗗ�ɖ߂�</a>]</td>\n";
		print "<td width='10'></td>\n";
		print "<td class='gray'>[<a href='javascript:history.back()'>�O�̉�ʂɖ߂�</a>]</td>\n";
		break;


	//�� �f�t�H���g
	default:
		print "<td class='gray'>[<a href='javascript:history.back()'>�O�̉�ʂɖ߂�</a>]</td>\n";
		break;


}
?>
</tr>
</table>
</td>
</tr>
</table>
