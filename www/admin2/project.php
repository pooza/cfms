<?php

//■ 起動
// -----------------------------------------------------------------------------
		require_once('xdef.admin.inc');
		// fcn_basic_auth();
		$con = fcn_db_connect();
// -----------------------------------------------------------------------------


// アクセス制限
		if(!isset($_COOKIE['cfms_admin2']))	error('不正なアクセスです。','close');


//■ モード処理
// ------------------------------------------------------------------------------------------------- [mode]
		$mode	=	fcn_verify_getprm ($_GET['mode']);
		switch($mode){


			// 案件の追加 ------------------------------------------------------------ [追加]
			case 'add':

				fcn_header_admin ('案件の追加');
				include_once('admin.tab.project.2.php');
				spacer(20);
		
				print "<div class='notice'>工事中</div>\n";
				break;


			// 案件からユーザを抽出 -------------------------------------------------- [ユーザ抽出]
			case 'proj-user':

				if(!isset($_GET[tid]))	error('不適切なアクセスです。','close');
				$tid = trim($_GET[tid]);

				fcn_header_admin ('案件からユーザを抽出');
				include_once('admin.tab.project.3.php');
				spacer(20);

				// SQL
				$sql	=	"select "
							.	"user.name as name, user.status as status, priv.user_id as id, user.password as pw, user.company as company "
							.	"from priv,user "
							.	"where priv.user_id=user.id and priv.project_id=$tid "
							. "order by user.company, user.section, user.id";
				$Rslt	=	fcn_sql_exec ($con,$sql);

				$rows	= mysql_num_rows ($Rslt);	// 表示アイテム数

				if($rows==0){
					error('この案件に関係するユーザはいません。','back');
				}else{
					$title = fcn_sql_sa("select name from project where id=".$tid);
					print "<div class='plain'>"
							.	"案件&nbsp;<font color='red'>$title</font>&nbsp;には、"
							.	"<font color='red'>$rows</font>人のユーザが登録されています。"
							.	"</div>\n";
					spacer(15);
?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='#cccccc'>
<tr bgcolor='#ccccff'>
<td class='plain'>ユーザ名</td>
<td class='plain'>ID</td>
<td class='plain'>PW</td>
<td class='plain'>会社名</td>
<td class='plain'>案件</td>
<td class='plain'>案内</td>
</tr>
<?				while ($Rec = mysql_fetch_array($Rslt)){	include	('admin.list.project.php');	}		?>
</table>
<?			}
				break;


			// ユーザから案件を抽出 -------------------------------------------------- [案件抽出]
			case 'user-proj':
			
				$tid	=	fcn_verify_getprm ($_GET['tid']);
				fcn_header_admin ('ユーザから案件を抽出');
				include_once('admin.tab.project.3.php');
				spacer(20);
				$user_name	=	fcn_get_username($tid);
				include_once('admin.form.priv.entry.php');

				break;


			// 案内用の表示 ---------------------------------------------------------- [案内]
			case 'user-info':

				$tid	=	fcn_verify_getprm ($_GET['tid']);
				fcn_header_admin ('案内用の表示');
				include_once('admin.tab.project.3.php');
				spacer(20);

				// --------------------------------------------------------------------- SQL
				$sql	=	'select '
							.	'user.name as name, user.id as id, user.password as pw, user.company as company '
							.	'from user '
							.	"where user.id='$tid'";
				$Rslt	=	fcn_sql_exec ($con,$sql);
				$Rec	=	mysql_fetch_array($Rslt);
				// --------------------------------------------------------------------- /

				// 苗字を切り出す
				$Name	=	explode(' ',$Rec['name']);	$fam_name	=	$Name['0'];

				$HTML[]	= '<textarea name=guide rows=20 cols=70>';
				if($Rec['company'] !='(フリー)')	$HTML[]	= $Rec['company'];
				$HTML[]	= $fam_name.' 様';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= '弊社の「COMMONSファイル管理システム」に';
				$HTML[]	= 'ユーザ登録いたしました。';
				$HTML[]	= '';
				$HTML[]	= '当システムでは、プロジェクトのメンバー間で';
				$HTML[]	= '安全にファイルを共有することができます。';
				$HTML[]	= 'ぜひご利用ください。';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= _SITE_NAME_;
				$HTML[]	= _SITE_URL_;
				$HTML[]	= _SITE_NAME_	.' ヘルプ';
				$HTML[]	= _SITE_URL_	.'help/';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= '■ログイン情報';
				$HTML[]	= '--------------------------------------------------';
				$HTML[]	= 'ログインID：　'.$Rec['id'];
				$HTML[]	= 'パスワード：　'.$Rec['pw'];
				$HTML[]	= '--------------------------------------------------';
				$HTML[]	= '';
				$HTML[]	= '';
				// --------------------------------------------------------------------- SQL
				$sql	=	"select project.name as name from project,priv "
							.	"where project.id=priv.project_id and priv.user_id='$tid' "
							.	"order by priv.project_id desc";
				$Rslt	=	fcn_sql_exec ($con,$sql);
				// --------------------------------------------------------------------- /
				$HTML[]	= '■アクセス可能な案件(プロジェクト)';
				$HTML[]	= '--------------------------------------------------';
				while	($Rec	=	mysql_fetch_array($Rslt)){
				$HTML[]	=	'・'.$Rec['name'];
				}
				$HTML[]	= '--------------------------------------------------';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= '以上、よろしくお願いいたします。';
				$HTML[]	= '　';
				$HTML[]	= '</textarea>';
	
				print implode("\n",$HTML);
				break;


			// 案件の一覧 ------------------------------------------------------------ [一覧]
			case 'list':

				fcn_header_admin ('案件一覧');
				include_once('admin.tab.project.1.php');
				spacer(20);

				// SQL
				$sql	=	"select project.id, project.name, project.owner, project.status, project.access_date as a_date,"
							.	" count(priv.user_id) as users "
							.	"from"
							.	" project,priv "
							.	"where"
						//.	" project.id = priv.project_id and"
							.	" project.id = priv.project_id "
							.	"group by priv.project_id "
							.	"order by project.id desc";
				$Rslt	=	fcn_sql_exec ($con,$sql);
	
				$recs	=	fcn_sql_sa ('select count(id) from project');	// 総アイテム
				$rows	= mysql_num_rows ($Rslt);	// 表示アイテム数

				if($rows==0){
					if($recs==0){
						error('まだ案件が登録されていません。','back');
					}else{
						error('このユーザに関係する案件はありません','back');
					}
				}else{
					print "<div class='plain'>全<font color='red'>$recs</font>件の案件が登録されています。</div>\n";
					spacer(15);
?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='#cccccc'>
<tr bgcolor='#ccccff'>
<td class='plain'>ID</td>
<td class='plain'>案件名</td>
<td class='plain'>オーナー</td>
<td class='plain'>最終アクセス</td>
<td class='plain'>ユーザ数</td>
</tr>
<?				while	($Rec = mysql_fetch_array($Rslt)){	include	('admin.list.project.php');	}	?>
</table>
<?			}
				break;
		}
// ------------------------------------------------------------------------------------------------- [/mode]


//■ フッタ出力
// -----------------------------------------------------------------------------
		spacer(20);
		include_once('admin.submenu.projects.php');
		include_once('_footer.admin.php');
// -----------------------------------------------------------------------------
?>