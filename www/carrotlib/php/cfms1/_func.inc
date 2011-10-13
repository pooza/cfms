<?php
function Nz ($str) {
	if ($str == "")
		return "&nbsp;";
	else
		return $str;
}

function OmitStr($str, $intLength) {
	if (strlen($str) <= $intLength)
		return $str;
	else {
		return (substr($str, 0, ($intLength - 3)) . "...");
	}
}

function CleanStr ($str, $boolEnableTag = false, $strOption = "a") {
	if (get_magic_quotes_gpc()) {
		stripslashes($str);
	}

	$str = trim($str);
	$str = mb_convert_encoding($str, "utf8", "auto");
	$str = mb_convert_kana($str, "KV" . $strOption, "utf8");
	
	if ($boolEnableTag == false)
		$str = strip_tags($str);

	//$str = stripslashes($str);
	//$str = str_replace("'", "\'", $str);
	//$str = mysql_real_escape_string($str);
	return $str;
}

function ztrim ($str) {
	return mb_ereg_replace("[ 　]*([^ 　]*)[ 　]*", "\\1", $str);
}

function Bool2Str ($bool, $strTrue = "TRUE", $strFalse = "FALSE") {
	if ($bool)
		return $strTrue;
	else
		return $strFalse;
}

function FormatSelect ($strName, $hash, $default = null, $strOnChange = "") {
	$strBody = "<select name='" . $strName . "' size='1' onchange='" . $strOnChange . "'>\n";

	foreach ($hash as $id => $strLabel) {
		if ($id == $default)
			$strBody .= "\t<option value='" . $id . "' selected>" . $strLabel . "</option>\n";
		else
			$strBody .= "\t<option value='" . $id . "'>" . $strLabel . "</option>\n";
	}

	$strBody .= "</select>";
	return $strBody . "\n";
}

function FormatRadio ($strName, $hash, $default = null, $strOnClick = "") {
	$arrayBody = array();

	foreach ($hash as $id => $strLabel) {
		if ($id == $default)
			$arrayBody[] = "<input type='radio' name='" . $strName . "' value='" . $id . "' onclick='" . $strOnClick . "' checked>" . $strLabel;
		else
			$arrayBody[] = "<input type='radio' name='" . $strName . "' value='" . $id . "' onclick='" . $strOnClick . "'>" . $strLabel;
	}
	return join($arrayBody, "<br>\n");
}

function MimeEncode ($str) {
	return mb_encode_mimeheader($str);
}

function GetMicroTime(){ 
	list($msec, $sec) = explode(" ", microtime()); 
	return ((float)$sec + (float)$msec); 
} 

function Zen2Han ($str) {
	return mb_convert_kana($str, "ks");
}

function myRound ($num) {
	return floor($num + 0.5);
}

// 月配列
$hashMonth = array("" => "...");
for ($i = 1 ; $i <= 12 ; $i ++)
	$hashMonth[$i] = $i;

// 日配列
$hashDay = array("" => "...");
for ($i = 1 ; $i <= 31 ; $i ++)
	$hashDay[$i] = $i;
?>
