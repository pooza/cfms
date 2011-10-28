
<table width='100%' cellspacing='0' cellpadding='0' border='0'>
<tr>
<td align='right'>
<table cellspacing='0' cellpadding='0' border='0'>
<tr class='gray'>
<?
switch($_GET[mode]){

	//■ ユーザ登録結果の表示
	case "result":
		print "<td class='gray'>[<a href='user.php?mode=list'>ユーザ検索へ</a>]</td>\n";
		print "<td width='10'></td>\n";
		print "<td class='gray'>[<a href='user.php?mode=add'>さらに登録を続ける</a>]</td>\n";
		break;


	//■ ユーザから案件を抽出
	case "user-proj":
		print "<td class='gray'>[<a href='project.php?mode=list'>案件一覧に戻る</a>]</td>\n";
		print "<td width='10'></td>\n";
		print "<td class='gray'>[<a href='javascript:history.back()'>前の画面に戻る</a>]</td>\n";
		break;


	//■ 案件からユーザを抽出
	case "proj-user":
		print "<td class='gray'>[<a href='project.php?mode=list'>案件一覧に戻る</a>]</td>\n";
		print "<td width='10'></td>\n";
		print "<td class='gray'>[<a href='javascript:history.back()'>前の画面に戻る</a>]</td>\n";
		break;


	//■ デフォルト
	default:
		print "<td class='gray'>[<a href='javascript:history.back()'>前の画面に戻る</a>]</td>\n";
		break;


}
?>
</tr>
</table>
</td>
</tr>
</table>
