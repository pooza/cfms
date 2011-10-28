<?php
/* --------------------------------------------------------------------------

	CFMS 管理画面 専用関数ライブラリ

	2005.04.21	01	cms

-------------------------------------------------------------------------- */



//■ IDからユーザ名を取得する
function fcn_get_username($id)	{
	return fcn_sql_sa("select name from user where id='".$id."'");
}



//■ 画面ヘッダの出力
function fcn_header_admin ($subtitle){
	include_once ("_header.admin.php");
	print "<body>"."\n";
	include_once ("_menu.admin.php");
	
	print "<table cellspacing='0' cellpadding='0' border='0'>"."\n";
	print "<tr>"."\n";
	print "<td valign='top' width='10'></td>"."\n";
	print "<td valign='top'>"."\n"."\n";

	spacer(5);
	print "<div class='function'>"._APP_NAME_S_."：&nbsp;".$subtitle."</div>";
	spacer(15);
}



//■ ユーザ登録
function fcn_user_entry ($con,$_POST){
	$Post	=	fcn_clean_array ($_POST,'db');

	// 必須処理
	// ---------------------------------------------------------------------------
	if(empty($Post[name]))		{	error("名前を入力してください。","back");						}
	if(empty($Post[name_r]))	{	error("氏名（英語）を入力してください。","back");		}
	if(empty($Post[email]))		{	error("メールアドレスを入力してください。","back");	}
	//if(empty($Post[company]))	{	error("会社名を入力してください。","back");					}
	if(empty($Post[pw]))			{	error("パスワードを入力してください。","back");			}

	// 妥当性チェック
	// ---------------------------------------------------------------------------
	if(!fcn_validate_mail($Post[email])){	error("不適切なメールアドレスです。","back");	}
	if(mb_detect_encoding($Post[pw]) != "ASCII"){	error("不適切なパスワードです。","back");	}

	// SQL
	// ---------------------------------------------------------------------------
		$date	=	date("Y-m-d H:i:s");
		switch ($Post[flag]){

			//■ 登録の場合
	    case "add":
				// --------------------------------------------------------------------
				// 重複登録チェック
				// --------------------------------------------------------------------
				$dup_ck	=	fcn_sql_sa("select id from user where id='".$Post[email]."' group by id");
				if(!empty($dup_ck)){
					error	("重複登録です：<br>メールアドレス&nbsp;".$Post[email],"back");
				}
				// ---------------------------------------------------------------------
				// ユーザ登録
				// ---------------------------------------------------------------------
				$sql	=	"insert into user set "
							.	"id"					."='".	$Post[email]		."',"
							.	"create_date"	."='".	$date						."',"
							.	"name"				."='".	$Post[name]			."',"
							.	"name_read"		."='".	$Post[name_r]		."',"
							.	"email"				."='".	$Post[email]		."',"
							.	"company"			."='".	$Post[company]	."',"
							.	"section"			."='".	$Post[section]	."',"
							.	"title"				."='".	$Post[title]		."',"
							.	"password"		."='".	$Post[pw]				."'";
				$Rslt =	fcn_sql_exec($con,$sql);
				// ---------------------------------------------------------------------
				// ユーザを案件にアサイン
				// ---------------------------------------------------------------------
				if($Post[priv] != "NULL"){
					$Priv	=	explode("/",$Post[priv]);
					asort($Priv);
					foreach ($Priv as $key => $value){
						$sql	=	"insert into priv set "
									.	"project_id"	."='".$Priv[$key]		."',"
									.	"user_id"			."='".$Post[email]	."',"
									.	"class_id"		."='"."IDEA"				."',"
									.	"priv"				."='"."ALL"					."'";
						$Rslt =	fcn_sql_exec($con,$sql);
					}
				}
				break;

			//■ 編集の場合
	    case "edit":
				// ---------------------------------------------------------------------
				// [追加] 必須処理
				// ---------------------------------------------------------------------
				if(empty($Post[id])){	error("IDを入力してください。","back");}
				// ---------------------------------------------------------------------
				// [追加] 妥当性チェック
				// ---------------------------------------------------------------------
				if(mb_detect_encoding($Post[id]) != "ASCII"){	error("不適切なIDです。","back");	}
				// ---------------------------------------------------------------------
				// ID修正の場合
				// ---------------------------------------------------------------------
				$old_id	= fcn_sql_sa("select id from user where id='$Post[tid]'");
				if($Post[id] != $old_id){
					$new_id	=	$Post[id];
					fcn_sql_exec($con,"update idea set owner='$new_id' where owner='$old_id'");
					fcn_sql_exec($con,"update igroup set owner='$new_id' where owner='$old_id'");
					fcn_sql_exec($con,"update priv set user_id='$new_id' where user_id='$old_id'");
					fcn_sql_exec($con,"update project set owner='$new_id' where owner='$old_id'");
				}
				// ---------------------------------------------------------------------
				// ユーザ情報の更新
				// ---------------------------------------------------------------------
				$sql	=	"update user set "
							.	"id"					."='".	$Post[id]				."',"
							.	"update_date"	."='".	$date						."',"
							.	"name"				."='".	$Post[name]			."',"
							.	"name_read"		."='".	$Post[name_r]		."',"
							.	"email"				."='".	$Post[email]		."',"
							.	"company"			."='".	$Post[company]	."',"
							.	"section"			."='".	$Post[section]	."',"
							.	"title"				."='".	$Post[title]		."',"
							.	"password"		."='".	$Post[pw]				."', "
							.	"status"			."='".	$Post[status]		."' "
							.	"where id"		."='".	$Post[tid]			."'";
				$Rslt =	fcn_sql_exec($con,$sql);
				// ---------------------------------------------------------------------
				// ユーザを案件にアサイン
				// ---------------------------------------------------------------------
				// 既存のアサイン設定を削除
				fcn_sql_exec($con,"delete from priv where user_id='$Post[tid]'");
				// アサイン設定
				if($Post['status'] !='LEAVE'){	// 退会の場合は消したままになる
					if($Post['priv'] != "NULL"){
						$Priv	=	explode("/",$Post[priv]);
						asort($Priv);
						foreach ($Priv as $key => $value){
							$sql	=	"insert into priv set "
										.	"project_id"	."='".	$Priv[$key]	."',"
										.	"user_id"			."='".	$Post[id]		."',"
										.	"class_id"		."='".	"IDEA"			."',"
										.	"priv"				."='".	"ALL"				."'";
							@mysql_query($sql);
						}
					}
				}
				break;
		}
	// ---------------------------------------------------------------------------

	return $Post;
}



//■ メニュー生成：[案件]
function fcn_make_sel_priv ($con,$fcn,$selected){
	$Rslt = fcn_sql_exec($con,"select id,name,owner from project order by id desc");

	switch($fcn){

	case "add":
		$HTML[]	= "<select name='Priv[]' size='10' multiple>";
		while ($Rec = mysql_fetch_array($Rslt)){
			if($Rec[id]==$selected){
				$HTML[]	= "<option value='$Rec[id]' selected>$Rec[name]</option>";
			}else{
				$HTML[]	= "<option value='$Rec[id]'>$Rec[name]</option>";
			}
		}
		break;

	case "edit":
		$HTML[]	= "<select name='Priv[]' size='20' multiple>";
		while ($Rec = mysql_fetch_array($Rslt)){
			$Rsub	=	mysql_query	("select project_id from priv where user_id='$selected' and project_id='$Rec[id]'");
			$rows	=	mysql_num_rows($Rsub);
			if($rows != 0){
				$HTML[]	= "<option value='$Rec[id]' selected>$Rec[name]</option>";
			}else{
				$HTML[]	= "<option value='$Rec[id]'>$Rec[name]</option>";
			}
		}
		break;
	}
	
	$HTML[]	= "</select>";
	print implode("\n",$HTML);
	unset ($HTML);
}



//■ メニュー生成：[検索]
function fcn_make_sel_search ($con,$type){
	switch($type){

	case "company":

		$Rslt = fcn_sql_exec($con,
						"select company from user where company is not NULL group by company order by company;");
		$HTML[]	= "<form>";
		$HTML[]	= "<select name='sel_company' size='1' onChange='location=this.options[this.selectedIndex].value'>";
		$HTML[]	= "<option value=''>会社名で絞り込み --> </option>";
		$HTML[]	= "<option value=''> ---------------- </option>";
		while ($Rec = mysql_fetch_array($Rslt)){
		$HTML[]	= "<option value='"._APP_URL_."user.php?mode=list&fws=".$Rec[company]."'>"
						.	$Rec[company]."</option>";
		}
		$HTML[]	= "</select>";
		$HTML[]	= "</form>";
		print implode("\n",$HTML);
		break;
	}
}



?>