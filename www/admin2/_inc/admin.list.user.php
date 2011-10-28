<?php


// キーワードの調整
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
		$rows	= mysql_num_rows($Rslt);	// 表示アイテム数
// -----------------------------------------------------------------------------


// 検索結果の表示
// -----------------------------------------------------------------------------
		print "<div class='plain'>"
				.	"キーワード「&nbsp;<font color='red'>".$keyword."</font>&nbsp;」の検索結果"
				.	"</div>\n";
		spacer(10);

		if($rows==0){
			print "<div class='notice'>キーワードにマッチするユーザがいませんでした。</div>\n";
		}else{
?>
<form action='<?=$PHP_SELF?>?mode=delete' method='POST' name='form_del'>
<table cellspacing='1' cellpadding='2' border='0' bgcolor='#cccccc'>
<tr bgcolor='skyblue'>
<td class='plain'>ID</td>
<td class='plain'>名前</td>
<td class='plain'>E-mail</td>
<td class='plain'>所属</td>
<td class='plain'>パスワード</td>
<td class='plain'>案件</td>
<td class='plain'>案内</td>
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
				print "<a href='$PHP_SELF?mode=edit&tid=$Rec[id]' title='$Rec[name]($Rec[name_read])の情報を編集'>"
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
<td class='gray'>[<a href='project.php?mode=user-proj&tid=<?=$Rec[id]?>'>案件</a>]</td>
<td class='gray'>[<a href='project.php?mode=user-info&tid=<?=$Rec[id]?>'>案内</a>]</td>
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