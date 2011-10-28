<?php

/* -----------------------------------------------

	G:A's	関数ライブラリ

	ver	1.0.0.0 beta	(05.05.31)	01	cms

-------------------------------------------------- */


//■■ 変更あり		一部の古い関数を削除（エラー表示系など）
//■■ 変更あり		fcn_make_sel
//■■ 変更あり		fcn_datetime_cvt
//■■ 変更あり		fcn_basic_auth
//■■ 関数追加		fcn_get_tid
//■■ 関数追加		fcn_verify_getprm
//■■ 変更あり		trace


// ------------------------------------------------------------------------------------------ [基本]

	//■ エラー出力
	// ---------------------------------------------------------------------------
	function error ($alert,$link){
		switch($link){
			case 'back':
				$link	=	"<a href='Javascript:history.back()'>【戻る】</a>";		break;
			case 'close':
				$link	=	"<a href='Javascript:window.close()'>【閉じる】</a>";	break;
			default:
				$link	=	"<a href='$link'>【戻る】</a>";												break;
		}
		include_once('gen.error.php');																		exit;
	}

	//■ 変数のテスト出力
	// ---------------------------------------------------------------------------
	function trace ($val){
		if(is_array($val)){
			$array	=	$val;
			$HTML[]	= "<table cellspacing='2' cellpadding='2' border='1'>";
			foreach ($array as $key => $value){
				if(is_array($array[$key])){
					$HTML[]	= "<tr>";
					$HTML[]	= "<td bgcolor='#dcdcdc' class='mono'>$key</td>";
					$HTML[]	= "<td bgcolor='#ffffff' class='mono'>";

					$HTML[]	= "<table cellspacing='1' cellpadding='2' border='0' bgcolor='gray'>";
					$sub_array	=	$array[$key];
					foreach ($sub_array as $sub_key => $sub_value){
						$HTML[]	= "<tr>";
						$HTML[]	= "<td bgcolor='#dcdcdc' class='mono'>$sub_key</td>";
						$HTML[]	= "<td bgcolor='#ffffff' class='mono'>$sub_array[$sub_key]</td>";
						$HTML[]	= "</tr>";
					}
					$HTML[]	= "</table>";

					$HTML[]	= "</td>";
					$HTML[]	= "</tr>";
				}else{
					$HTML[]	= "<tr>";
					$HTML[]	= "<td bgcolor='#dcdcdc' class='mono'>$key</td>";
					$HTML[]	= "<td bgcolor='#ffffff' class='mono'>$array[$key]</td>";
					$HTML[]	= "</tr>";
				}
			}	
			$HTML[]	= "</table>";
			print implode("\n",$HTML);
		}else{
			print "<div><font size='2' color='purple'>$val</font></div>\n";
		}
	}

	//■ スペーサーの挿入
	// ---------------------------------------------------------------------------
	function spacer	($height){
		print "<img src='images/_spacer.gif' width='100%' height='$height'><br>\n";
	}

	//■ ターゲットIDを取得する
	// ---------------------------------------------------------------------------
	function fcn_get_tid ($tid){
		if(!isset($tid))	error('対象が見つかりません。','back');
		if(empty($tid))		error('対象に値がありません。','back');
		return intval(trim($tid));
	}

	//■ GETパラメータを確認する
	// ---------------------------------------------------------------------------
	function fcn_verify_getprm ($prm){
		if(!isset($prm))	error('パラメータが見つかりません。','back');
		if(empty($prm))		error('パラメータに値がありません。','back');
		return trim($prm);
	}

// ------------------------------------------------------------------------------------------ [/基本]



//■ BASIC認証
function fcn_basic_auth (){
	if(	!isset($_SERVER["PHP_AUTH_USER"])						||
			$_SERVER["PHP_AUTH_USER"]	!=	_ADMIN_USER_	||
			$_SERVER["PHP_AUTH_PW"] 	!=	_ADMIN_PASS_	)
	{
		header("WWW-Authenticate: Basic realm=\""._SITE_REALM_."\"");
		header('HTTP/1.0 401 Unauthorized');
		error("管理者以外は入れないのです。","close");
	}
}



//■ DB接続
function fcn_db_connect (){
	$con = @mysql_connect(_DB_HOST_,_DB_USER_,_DB_PASS_);
	mysql_query('SET NAMES sjis');
	if(!$con){
		error('DBサーバとの接続に失敗しました。','back');
	}else{
		mysql_select_db(_DB_NAME_) or die (error('DBにアクセスできません。','back'));
		return $con;
	}
}



//■ SQL: クエリを投げ、エラー確認を行う
function fcn_sql_exec ($con,$sql){
	$Rslt	=	@mysql_query($sql) or die(
		error(
				"データベースにダメ出しされました。<br>\n"
			.	"これがデータベースからのエラーメッセージです。<br>\n"
			.	"<hr size='1' color='#99ff99' noshade>\n"
			.	mysql_error($con)
			.	"<hr size='1' color='#99ff99' noshade>\n"
			.	"（たとえば重複登録の場合、「Duplicate entry」から始まるメッセージになっています）<br>\n"
			,	"back")
	);
	return $Rslt;
}



//■ SQL: 返り値が単数の問い合わせを行う
function fcn_sql_sa ($sql){
	$Rslt	= mysql_query($sql);
	$Rec	= mysql_fetch_array($Rslt);
	return $Rec[0];
}



//■ 環境変数の取得
function fcn_get_env (){
	if($_SERVER["REMOTE_HOST"]=="" or $_SERVER["REMOTE_HOST"]==$_SERVER["REMOTE_ADDR"]){
		$rhost	=	gethostbyaddr($_SERVER["REMOTE_ADDR"]);
	}else{
		$rhost	=	$_SERVER["REMOTE_HOST"];
	}
	return array(
		"raddr"	=>	$_SERVER["REMOTE_ADDR"],
		"rhost"	=>	$rhost,
		"ua"		=>	$_SERVER["HTTP_USER_AGENT"]
	);
}



//■ $_POSTの空欄チェック
function fcn_post_emptyck ($_POST){
	$i=0;
	foreach ($_POST as $key => $value){
		if(empty($_POST[$key])){
			$empty_key[$i] = $key;
			$i++;
		}
	}
	if(is_array($empty_key)==true){
		return $empty_key;
	}elseif(is_array($empty_key)==false){
		$empty_key = "filled up";
		return $empty_key;
	}
}



//■ 配列のクリーニング
function fcn_clean_array ($Array,$flag){
	foreach ($Array as $key => $value) {
		$Array[$key] = trim($Array[$key]);
		if(!empty($Array[$key]) && strlen($Array[$key])<=2){
			$UA = array("MSIE","Safari");
			foreach ($UA as $uakey => $value) {
				$ck = strstr($_SERVER[HTTP_USER_AGENT], $UA[$uakey]);
				if($ck == FALSE){$Array[$uakey] = mb_convert_encoding($Array[$key], "SJIS", "auto");}
				break;
			}
		}
		switch($flag){
			case "sjis_print":
				$Array[$key] = strip_tags		($Array[$key]);
				$Array[$key] = stripslashes	($Array[$key]);
				$Array[$key] = htmlspecialchars	($Array[$key]);
				$Array[$key] = str_replace	("'", "\'", $Array[$key]);
				break;
			case "strip":
				$Array[$key] = strip_tags		($Array[$key]);
				$Array[$key] = htmlspecialchars	($Array[$key]);
				break;
			default:
				$Array[$key] = strip_tags		($Array[$key]);
				$Array[$key] = stripslashes	($Array[$key]);
				$Array[$key] = str_replace	("'", "\'", $Array[$key]);
				break;
		}
	}
	return $Array;
}



//■ timestamp(14) の分割
function fcn_ts_to_array ($timestamp){
	$TS[Y]	=	substr($timestamp,	0, 4);
	$TS[M]	=	substr($timestamp,	4, 2);
	$TS[D]	=	substr($timestamp,	6, 2);
	$TS[h]	=	substr($timestamp,	8, 2);
	$TS[m]	=	substr($timestamp, 10, 2);
	$TS[s]	=	substr($timestamp, 12, 2);
	
	return $TS;
}



//■ 日付(datetime)の書式変換
function fcn_datetime_cvt ($datetime,$mode){

		$DTex	= explode(" ",$datetime);
		$YMD	=	explode("-",$DTex[0]);
		$HMS	=	explode(":",$DTex[1]);
		$DT[year]		= $YMD[0];
		$DT[month]	= $YMD[1];
		$DT[day]		= $YMD[2];
		$DT[hour]		= $HMS[0];		
		$DT[minit]	= $HMS[1];
		$DT[second]	= $HMS[2];
		
	switch($mode){
		case $mode="yy.mm.dd":
			//yy.mm.dd
			$year = str_replace("20","",$DT[year]);
			$time =	$year.".".$DT[month].".".$DT[day];
			break;
		case $mode="yy.mm.dd(jp)":
			//yy年mm月dd日
			$year = str_replace("20","",$DT[year]);
			$time =	$year."年".$DT[month]."月".$DT[day]."日";
			break;
		default:
			//yy.mm.dd hh:mm
			$year = str_replace("20","",$DT[year]);
			$time =	$year.".".$DT[month].".".$DT[day]." ".$DT[hour].":".$DT[minit];
			break;
	}
	return $time;
}



//■ メールの妥当性チェック
function fcn_validate_mail ($addr){
	// ASCII以外はアウト
	if(mb_detect_encoding($addr) !="ASCII"){
		$ck	=	0;
	}else{
	// 正規表現による妥当性チェック
		$ck	= ereg(	'^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'
							.	'@'
							.	'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'
							.	'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $addr);
	}
	return $ck;
}



//■ DBのデータでポップアップメニューを生成する
function fcn_make_sel ($selname,$selected,$sql){
	$Result_make_sel = @mysql_query($sql);
	
	print "<select name='".$selname."' size=1>\n";
	if($selected=="guide"){
		print "<option value=''>選択してください --> </option>\n";
		print "<option value=''> ---------------- </option>\n";
	}
	while ($Rec = @mysql_fetch_array($Result_make_sel)){
		if($Rec[0]==$selected){
			print "<option value=".$Rec[0]." selected>".$Rec[1]."</option>\n";
		}else{
			print "<option value=".$Rec[0].">".$Rec[1]."</option>\n";
		}
	}
	print "</select>";
}



//■ アップロードの検査，保管ディレクトリへの移動
function fcn_ck_upload ($filepath){

	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
		$ck = move_uploaded_file($_FILES['upfile']['tmp_name'],$filepath);
		if($ck==TRUE){
			$Upfile[name] = $_FILES['upfile']['name'];
			$Upfile[type] = $_FILES['upfile']['type'];
			$Upfile[size] = $_FILES['upfile']['size'];
			return $Upfile;
		}elseif($ck==FALSE){
			error (
					"アップロードは異常終了しました。[アップ直後]<br>\n"
				.	"<hr size='1' color='#99ff99' noshade>\n"
				.	"一時ファイル 「".$_FILES['upfile']['tmp_name']."」 を <br>\n"
				.	"移動先「".$filepath."」<br>\n"
				.	"に移すことができません。移動先のパーミッションの問題かもしれません。<br>\n"
				,	"back");
		}
	}else{
		if(empty($_FILES['upfile']['name'])){
			$alert	=	"ファイルが指定されてません。";
		}else{
			$alert	= "「".$_FILES['upfile']['name']."」";
			switch($_FILES['upfile']['error']){
				case "0":
					$alert .= "エラーはないはず、なんですが…";
					break;
				case "1":
					$alert .= "は、php.ini の upload_max_filesize ディレクティブの値を超えています。";
					break;
				case "2":
					$alert .= "は、HTMLフォームで指定された MAX_FILE_SIZE を超えています。";
					break;
				case "3":
					$alert .= "は一部のみしかアップロードされていません。";
					break;
				case "4":
					$alert .= "はアップロードされませんでした。";
					break;	
			}
		}
		error ($alert,"back");
	}
}



// アップロードした画像ファイルの検査 （互換性のため残している：調整後、削除）
function fcn_ck_upimage ($Upfile){

	// 画像の情報を取得
	$ImgData	= GetImageSize(_DATA_PATH_TMP_.$Upfile[name]);

	// 画像形式の制限
	$ImgAllow	=	explode("/",_IMAGE_TYPE_);
	$ImgType	=	array("unknown","gif","jpeg","png","swf");
	$img_try	=	$ImgType[$ImgData[2]];
	if(!in_array($img_try,$ImgAllow)){
		error ("この画像は登録できません、ファイル形式をチェックしてください。","back");
	}

	// 画像サイズ制限
	$ImgSize	=	explode("/",_IMAGE_2D_);
	$width		=	$ImgSize[0];
	$height		=	$ImgSize[1];
	
	if($width != 0){
		if($width != $ImgData[0]){
			error ("この画像は登録できません。幅が規定サイズと合っていません。","back");
		}
	}
	 if($height != 0){
		if($height != $ImgData[1]){
			error ("この画像は登録できません。縦が規定サイズと合っていません。","back");
		}
	}

	$Upfile['2d']	= $ImgData[0]."/".$ImgData[1];
	return $Upfile;
}



//■ アップロードした画像ファイルのチェック
function fcn_ck_upfile_image ($Upfile,$limitW,$limitH){

	// 画像の情報を取得
	$ImgData	= GetImageSize(_DATA_PATH_TMP_.$Upfile[name]);
	$Upfile['w']	= $ImgData[0];
	$Upfile['h']	= $ImgData[1];

	// 画像形式の制限
	$ImgAllow	=	explode("/",_IMAGE_TYPE_);
	$ImgType	=	array("unknown","gif","jpeg","png","swf");
	$img_try	=	$ImgType[$ImgData[2]];
	if(!in_array($img_try,$ImgAllow)){
		error ("この画像は登録できません、ファイル形式をチェックしてください。","back");
	}

	// 画像サイズ制限
	if($limitW != 0){
		if($limitW != $ImgData[0]){	error("画像を登録できません。幅が規定サイズに合ってません。"	,"back");}
	}
	if($limitH != 0){
		if($limitH != $ImgData[1]){	error("画像を登録できません。高さが規定サイズに合ってません。","back");}
	}

	return $Upfile;
}



// UAによるCSSスイッチ
function fcn_css_switch (){
	$HTTPUA = $_SERVER["HTTP_USER_AGENT"];

	// OSの判別
	if(preg_match("/Win/",$HTTPUA)){
		$OS="win";
	}elseif(preg_match("/Mac/",$HTTPUA)){
		$OS="mac";
	}else{
		$OS="other";
	}
	// UAの判別
	if(preg_match("/MSIE/",$HTTPUA)){
		$UA="ie";
	}elseif(preg_match("/Safari/",$HTTPUA)){
		$UA="safari";
	}elseif(preg_match("/Mozilla\/?/",$HTTPUA)){
		$UA="ns";
	}else{
		$UA="something";
	}
	$css = $OS."_".$UA;
	
	// ありえない or 不明として扱うUAのリスト
	$unknown_UA[0] = "win_safari";
	$unknown_UA[1] = "other_ie";
	$unknown_UA[2] = "other_safari";
	$unknown_UA[3] = "other_something";
	
	if(in_array($css,$unknown_UA)){
		$css ="other.css";
	}else{
		$css ="$css.css";
	}

	return $css;
}



// -------------------------------------------------------------------
// ▽ 借り物の関数：

	// IT BOOSTから：文字列を任意の幅で強制的に折り返す
	function itbFold( $aStr, $aLength = 76 ) {
	  $aStr = ereg_replace("\r\n", "\n", $aStr);
	  $aStr = ereg_replace("\r", "\n", $aStr);
	  $arrLine = array();
	  $arrLine = split("\n", $aStr);

	  foreach( $arrLine as $id => $data ) {
	    $pos = 0;
	    do {
	      $ok = mb_strcut( $data, $pos, $aLength);
	      $result .= $ok."\n";
	      $data = mb_strcut( $data, $pos + $aLength );
	    } while ( strlen($data) >= $aLength  );
	    $result .=  $data;
	  }
	  return $result;
	}

// -------------------------------------------------------------------



// -------------------------------------------------------------------
// ▽ 関数メモ：

	// 定数をすべて出力する
	// trace	(get_defined_constants());

// -------------------------------------------------------------------
?>