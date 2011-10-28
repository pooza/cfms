<?php
/* --------------------------------------------------------------------

  CFMS 管理画面 専用 関数ライブラリ

	2007.04.13	01	cms

-------------------------------------------------------------------- */



// ------------------------------------------------------------------------------------------ [定番]

	// ■ 変数のテスト出力
	// ---------------------------------------------------------------------------
	function test ($val){	trace($val);}

// ------------------------------------------------------------------------------------------ [/定番]




	// ■ noticeの書き込み
	// ---------------------------------------------------------------------------
	function fcn_spdb_notice_entry ($con,$_POST){

		if(empty($_POST[content])){	fcn_error_print ("本文が空欄です。");}	//必須項目
		$Post = fcn_post_opt_DB($_POST);	//下処理

		//モード処理
		switch ($Post[flag]){
			//投稿
		 	case "add":
				$date_c	=	date("Y-m-d H:i:s");
				$sql		=	"insert into "._TABLE_NOT_." set "
								.	"date_c"			."='$date_c',"
								.	"app_id"			."='$Post[app_id]',"
								.	"subject"			."='$Post[subject]',"
								.	"content"			."='$Post[content]',"
								.	"type"				."='$Post[type]',"
								.	"adm_flag"		."='$Post[adm_flag]'";
				break;
			//編集
		 	case "edit":
				$sql		=	"update "	 		._TABLE_NOT_." set "
								.	"subject"			."='$Post[subject]',"
								.	"content"			."='$Post[content]' "
								.	"where id="		.$_POST[tid];
				break;
		}

		$Rslt	=	fcn_sql_exec ($con,$sql);
		return $Post;
	}



	// ■ list 表示時の背景色のコントロール
	// ---------------------------------------------------------------------------
	function fcn_list_bgc ($flag){
		switch($flag){
			case 'ACTIVE':	return '#ffffff';	break;
			case 'LEAVE':		return '#dddddd';	break;
			case 'FIX':			return '#dddddd';	break;
		}
	}


?>