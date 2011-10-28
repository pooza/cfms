<?php


// 起動
// -----------------------------------------------------------------------------
		require_once ("xdef.admin.inc");
		$con = fcn_db_connect();
// -----------------------------------------------------------------------------


// ユーザ追加
// -----------------------------------------------------------------------------
		if(isset($_POST[btn_user_confirm])){
			$Post	=	fcn_user_entry ($con,$_POST);
			switch($Post[flag]){
				case "add";
					header("Location: ".$PHP_SELF."?mode=result&tid=".$Post[email]);
					break;
				case "edit";
					header("Location: ".$PHP_SELF."?mode=result&tid=".$Post[id]);
					break;
			}
		}
// -----------------------------------------------------------------------------


// アクセス制限
// -----------------------------------------------------------------------------
		if(!isset($_COOKIE[cfms_admin2])){error("不正なアクセスです。","close");}
// -----------------------------------------------------------------------------


// --------------------------------------------------------------------------------- モード処理 開始
if(isset($_GET[mode]) && !empty($_GET[mode])){
	switch($_GET[mode]){


	// ユーザ追加モード ------------------------------------------------------------------------[追加]
	case "add":

		fcn_header_admin ("ユーザ追加");
		include_once("admin.tab.user.2.php");
		spacer(30);
		$fcn = "add";
		include_once("admin.form.user.entry.php");
		break;


	// ユーザ編集モード ------------------------------------------------------------------------[編集]
	case "edit":

		if(!isset($_GET[tid])){error("不適切なアクセスです。","close");}
		$tid = trim($_GET[tid]);

		fcn_header_admin ("ユーザ編集");
		include_once("admin.tab.user.3.php");
		spacer(30);
		$fcn = "edit";
		$user_name = fcn_get_username($tid);
		include_once("admin.form.user.entry.php");
		break;


	// ユーザ登録 結果表示モード -----------------------------------------------------------[登録結果]
	case "result":

		if(!isset($_GET[tid])){error("不適切なアクセスです。","close");}
		$tid = trim($_GET[tid]);

		fcn_header_admin ("ユーザ登録結果");
		include_once("admin.tab.user.3.php");
		spacer(30);
		$user_name = fcn_get_username($tid);
		print "<div class='plain'>"
				.	"ユーザ&nbsp;<font color='red'>$user_name</font>&nbsp;を登録しました。&nbsp;"
				.	"<span class='gray'>[<a href='user.php?mode=edit&tid=$tid'>再編集</a>]</span>&nbsp;"
				.	"<span class='gray'>[<a href='project.php?mode=user-info&tid=$tid'>案内</a>]</span>"
				.	"</div>\n";
		spacer(20);
		break;


	// ユーザ検索モード ------------------------------------------------------------------------[検索]
	case "list":

		fcn_header_admin ("ユーザ検索");
		include_once("admin.tab.user.1.php");
		spacer(20);

		$recs	=	fcn_sql_sa ("select count(id) from user");	// 総人数
		if(!$recs==0){
			print "<div class='plain'>全<font color='red'>$recs</font>人のユーザが登録されています。</div>";
			spacer(15);
			include_once("admin.form.user.search.php");
			spacer(30);
		}

		// 検索実行
		if(isset($_POST[fws])){
			$keyword	=	$_POST[fws];
			include_once("admin.list.user.php");
		}elseif(isset($_GET[fws])){
			$keyword	=	$_GET[fws];
			include_once("admin.list.user.php");
		}
		break;
	}
// --------------------------------------------------------------------------------- モード処理 終了
	spacer(20);

	// サブメニュー出力
	include_once("admin.submenu.projects.php");

	// フッタ出力
	include_once("_footer.admin.php");

}else{
// -------------------------------------------------------------------------------------- モードレス
	error ("正しくない方法でこの画面を開いています。","back");
}
?>