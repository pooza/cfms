<?php

/* -----------------------------------------------

	G:A's	�֐����C�u����

	ver	1.0.0.0 beta	(05.05.31)	01	cms

-------------------------------------------------- */


//���� �ύX����		�ꕔ�̌Â��֐����폜�i�G���[�\���n�Ȃǁj
//���� �ύX����		fcn_make_sel
//���� �ύX����		fcn_datetime_cvt
//���� �ύX����		fcn_basic_auth
//���� �֐��ǉ�		fcn_get_tid
//���� �֐��ǉ�		fcn_verify_getprm
//���� �ύX����		trace


// ------------------------------------------------------------------------------------------ [��{]

	//�� �G���[�o��
	// ---------------------------------------------------------------------------
	function error ($alert,$link){
		switch($link){
			case 'back':
				$link	=	"<a href='Javascript:history.back()'>�y�߂�z</a>";		break;
			case 'close':
				$link	=	"<a href='Javascript:window.close()'>�y����z</a>";	break;
			default:
				$link	=	"<a href='$link'>�y�߂�z</a>";												break;
		}
		include_once('gen.error.php');																		exit;
	}

	//�� �ϐ��̃e�X�g�o��
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

	//�� �X�y�[�T�[�̑}��
	// ---------------------------------------------------------------------------
	function spacer	($height){
		print "<img src='images/_spacer.gif' width='100%' height='$height'><br>\n";
	}

	//�� �^�[�Q�b�gID���擾����
	// ---------------------------------------------------------------------------
	function fcn_get_tid ($tid){
		if(!isset($tid))	error('�Ώۂ�������܂���B','back');
		if(empty($tid))		error('�Ώۂɒl������܂���B','back');
		return intval(trim($tid));
	}

	//�� GET�p�����[�^���m�F����
	// ---------------------------------------------------------------------------
	function fcn_verify_getprm ($prm){
		if(!isset($prm))	error('�p�����[�^��������܂���B','back');
		if(empty($prm))		error('�p�����[�^�ɒl������܂���B','back');
		return trim($prm);
	}

// ------------------------------------------------------------------------------------------ [/��{]



//�� BASIC�F��
function fcn_basic_auth (){
	if(	!isset($_SERVER["PHP_AUTH_USER"])						||
			$_SERVER["PHP_AUTH_USER"]	!=	_ADMIN_USER_	||
			$_SERVER["PHP_AUTH_PW"] 	!=	_ADMIN_PASS_	)
	{
		header("WWW-Authenticate: Basic realm=\""._SITE_REALM_."\"");
		header('HTTP/1.0 401 Unauthorized');
		error("�Ǘ��҈ȊO�͓���Ȃ��̂ł��B","close");
	}
}



//�� DB�ڑ�
function fcn_db_connect (){
	$con = @mysql_connect(_DB_HOST_,_DB_USER_,_DB_PASS_);
	mysql_query('SET NAMES sjis');
	if(!$con){
		error('DB�T�[�o�Ƃ̐ڑ��Ɏ��s���܂����B','back');
	}else{
		mysql_select_db(_DB_NAME_) or die (error('DB�ɃA�N�Z�X�ł��܂���B','back'));
		return $con;
	}
}



//�� SQL: �N�G���𓊂��A�G���[�m�F���s��
function fcn_sql_exec ($con,$sql){
	$Rslt	=	@mysql_query($sql) or die(
		error(
				"�f�[�^�x�[�X�Ƀ_���o������܂����B<br>\n"
			.	"���ꂪ�f�[�^�x�[�X����̃G���[���b�Z�[�W�ł��B<br>\n"
			.	"<hr size='1' color='#99ff99' noshade>\n"
			.	mysql_error($con)
			.	"<hr size='1' color='#99ff99' noshade>\n"
			.	"�i���Ƃ��Ώd���o�^�̏ꍇ�A�uDuplicate entry�v����n�܂郁�b�Z�[�W�ɂȂ��Ă��܂��j<br>\n"
			,	"back")
	);
	return $Rslt;
}



//�� SQL: �Ԃ�l���P���̖₢���킹���s��
function fcn_sql_sa ($sql){
	$Rslt	= mysql_query($sql);
	$Rec	= mysql_fetch_array($Rslt);
	return $Rec[0];
}



//�� ���ϐ��̎擾
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



//�� $_POST�̋󗓃`�F�b�N
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



//�� �z��̃N���[�j���O
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



//�� timestamp(14) �̕���
function fcn_ts_to_array ($timestamp){
	$TS[Y]	=	substr($timestamp,	0, 4);
	$TS[M]	=	substr($timestamp,	4, 2);
	$TS[D]	=	substr($timestamp,	6, 2);
	$TS[h]	=	substr($timestamp,	8, 2);
	$TS[m]	=	substr($timestamp, 10, 2);
	$TS[s]	=	substr($timestamp, 12, 2);
	
	return $TS;
}



//�� ���t(datetime)�̏����ϊ�
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
			//yy�Nmm��dd��
			$year = str_replace("20","",$DT[year]);
			$time =	$year."�N".$DT[month]."��".$DT[day]."��";
			break;
		default:
			//yy.mm.dd hh:mm
			$year = str_replace("20","",$DT[year]);
			$time =	$year.".".$DT[month].".".$DT[day]." ".$DT[hour].":".$DT[minit];
			break;
	}
	return $time;
}



//�� ���[���̑Ó����`�F�b�N
function fcn_validate_mail ($addr){
	// ASCII�ȊO�̓A�E�g
	if(mb_detect_encoding($addr) !="ASCII"){
		$ck	=	0;
	}else{
	// ���K�\���ɂ��Ó����`�F�b�N
		$ck	= ereg(	'^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'
							.	'@'
							.	'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'
							.	'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $addr);
	}
	return $ck;
}



//�� DB�̃f�[�^�Ń|�b�v�A�b�v���j���[�𐶐�����
function fcn_make_sel ($selname,$selected,$sql){
	$Result_make_sel = @mysql_query($sql);
	
	print "<select name='".$selname."' size=1>\n";
	if($selected=="guide"){
		print "<option value=''>�I�����Ă������� --> </option>\n";
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



//�� �A�b�v���[�h�̌����C�ۊǃf�B���N�g���ւ̈ړ�
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
					"�A�b�v���[�h�ُ͈�I�����܂����B[�A�b�v����]<br>\n"
				.	"<hr size='1' color='#99ff99' noshade>\n"
				.	"�ꎞ�t�@�C�� �u".$_FILES['upfile']['tmp_name']."�v �� <br>\n"
				.	"�ړ���u".$filepath."�v<br>\n"
				.	"�Ɉڂ����Ƃ��ł��܂���B�ړ���̃p�[�~�b�V�����̖�肩������܂���B<br>\n"
				,	"back");
		}
	}else{
		if(empty($_FILES['upfile']['name'])){
			$alert	=	"�t�@�C�����w�肳��Ă܂���B";
		}else{
			$alert	= "�u".$_FILES['upfile']['name']."�v";
			switch($_FILES['upfile']['error']){
				case "0":
					$alert .= "�G���[�͂Ȃ��͂��A�Ȃ�ł����c";
					break;
				case "1":
					$alert .= "�́Aphp.ini �� upload_max_filesize �f�B���N�e�B�u�̒l�𒴂��Ă��܂��B";
					break;
				case "2":
					$alert .= "�́AHTML�t�H�[���Ŏw�肳�ꂽ MAX_FILE_SIZE �𒴂��Ă��܂��B";
					break;
				case "3":
					$alert .= "�͈ꕔ�݂̂����A�b�v���[�h����Ă��܂���B";
					break;
				case "4":
					$alert .= "�̓A�b�v���[�h����܂���ł����B";
					break;	
			}
		}
		error ($alert,"back");
	}
}



// �A�b�v���[�h�����摜�t�@�C���̌��� �i�݊����̂��ߎc���Ă���F������A�폜�j
function fcn_ck_upimage ($Upfile){

	// �摜�̏����擾
	$ImgData	= GetImageSize(_DATA_PATH_TMP_.$Upfile[name]);

	// �摜�`���̐���
	$ImgAllow	=	explode("/",_IMAGE_TYPE_);
	$ImgType	=	array("unknown","gif","jpeg","png","swf");
	$img_try	=	$ImgType[$ImgData[2]];
	if(!in_array($img_try,$ImgAllow)){
		error ("���̉摜�͓o�^�ł��܂���A�t�@�C���`�����`�F�b�N���Ă��������B","back");
	}

	// �摜�T�C�Y����
	$ImgSize	=	explode("/",_IMAGE_2D_);
	$width		=	$ImgSize[0];
	$height		=	$ImgSize[1];
	
	if($width != 0){
		if($width != $ImgData[0]){
			error ("���̉摜�͓o�^�ł��܂���B�����K��T�C�Y�ƍ����Ă��܂���B","back");
		}
	}
	 if($height != 0){
		if($height != $ImgData[1]){
			error ("���̉摜�͓o�^�ł��܂���B�c���K��T�C�Y�ƍ����Ă��܂���B","back");
		}
	}

	$Upfile['2d']	= $ImgData[0]."/".$ImgData[1];
	return $Upfile;
}



//�� �A�b�v���[�h�����摜�t�@�C���̃`�F�b�N
function fcn_ck_upfile_image ($Upfile,$limitW,$limitH){

	// �摜�̏����擾
	$ImgData	= GetImageSize(_DATA_PATH_TMP_.$Upfile[name]);
	$Upfile['w']	= $ImgData[0];
	$Upfile['h']	= $ImgData[1];

	// �摜�`���̐���
	$ImgAllow	=	explode("/",_IMAGE_TYPE_);
	$ImgType	=	array("unknown","gif","jpeg","png","swf");
	$img_try	=	$ImgType[$ImgData[2]];
	if(!in_array($img_try,$ImgAllow)){
		error ("���̉摜�͓o�^�ł��܂���A�t�@�C���`�����`�F�b�N���Ă��������B","back");
	}

	// �摜�T�C�Y����
	if($limitW != 0){
		if($limitW != $ImgData[0]){	error("�摜��o�^�ł��܂���B�����K��T�C�Y�ɍ����Ă܂���B"	,"back");}
	}
	if($limitH != 0){
		if($limitH != $ImgData[1]){	error("�摜��o�^�ł��܂���B�������K��T�C�Y�ɍ����Ă܂���B","back");}
	}

	return $Upfile;
}



// UA�ɂ��CSS�X�C�b�`
function fcn_css_switch (){
	$HTTPUA = $_SERVER["HTTP_USER_AGENT"];

	// OS�̔���
	if(preg_match("/Win/",$HTTPUA)){
		$OS="win";
	}elseif(preg_match("/Mac/",$HTTPUA)){
		$OS="mac";
	}else{
		$OS="other";
	}
	// UA�̔���
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
	
	// ���肦�Ȃ� or �s���Ƃ��Ĉ���UA�̃��X�g
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
// �� �؂蕨�̊֐��F

	// IT BOOST����F�������C�ӂ̕��ŋ����I�ɐ܂�Ԃ�
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
// �� �֐������F

	// �萔�����ׂďo�͂���
	// trace	(get_defined_constants());

// -------------------------------------------------------------------
?>