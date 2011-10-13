<?php
if (isset($db))
	require_once("_class/log.inc");

require_once("_class/socket.inc");
require_once("_func.inc");
define("URL_PATTERN", "(ftp|https?)://[-_.!~a-zA-Z0-9;/?:@&=+$,%#]+");

class URL {
	var $All;
	var $Scheme;
	var $Host;
	var $Port;
	var $Path;
	var $User;
	var $Password;
	var $Query;

	function URL ($strURL) {
		$this->All = $strURL;

		$url = parse_url($this->All);
		$this->Scheme = $url["scheme"];
		$this->Host = $url["host"];
		$this->Port = $url["port"];
		$this->Path = $url["path"];
		$this->User = $url["user"];
		$this->Password = $url["pass"];
		$this->Query = $url["query"];

		if ($this->Path == "")
			$this->Path = "/";

		if ($this->Port == "") {
			$arrayService = array(
				"http" => 80,
				"https" => 443,
				"ftp" => 21);
			$this->Port = $arrayService[$this->Scheme];
		}

		return (($this->Scheme != "") && ($this->Host != "") && ($this->Port != ""));
	}

	function IsValid () {
		return (mb_ereg(URL_PATTERN, $this->All));
	}

	function IsEnable () {
		if (mb_ereg("https?", $this->Scheme) == false)
			return false;

		$sock = new Socket($this->Host, $this->Port);
		if ($sock->Connected == false)
			return false;

		$sock->Put("HEAD " . $this->Path . " HTTP/1.0");
		$sock->Put("Host: " . $this->Host);
		$sock->Put(); //空行
		return mb_ereg("^HTTP/[0-9\.]+ [1-3][0-9][0-9]", $sock->Get());
	}

	function GetRemoteContent () {
		if (mb_ereg("https?", $this->Scheme) == false)
			return false;

		$sock = new Socket($this->Host, $this->Port);
		if ($sock->Connected == false)
			return false;

		$sock->SetTimeOut(1);
		$sock->Put("GET " . $this->Path . " HTTP/1.0");
		$sock->Put("Host: " . $this->Host);
		$sock->Put(); //空行

		$strBody = "";
		$boolBody = false;
		while ($sock->EOF() == false) {
			$str = trim($sock->Get());

			// 最初の空行以降を取り込む
			if ($boolBody)
				$strBody .= ($str . "\n");
			else
				$boolBody = ($str == "");
		}

		$strBody = mb_convert_encoding($strBody, "utf8", "auto");
		return $strBody;
	}

	function GetTitle () {
		return GetElement("title", $this->GetRemoteContent());
	}
}

class ImageURL extends URL {
	var $X;
	var $Y;

	function ImageURL ($strURL) {
		$this->All = $strURL;

		$url = parse_url($this->All);
		$this->Scheme = $url["scheme"];
		$this->Host = $url["host"];
		$this->Port = $url["port"];
		$this->Path = $url["path"];
		$this->User = $url["user"];
		$this->Password = $url["pass"];
		$this->Query = $url["query"];

		if ($this->Path == "")
			$this->Path = "/";

		return true;
	}

	function Format ($strName = "", $strOption = null) {
		$arrayInfo = getimagesize($this->All);
		$this->X = $arrayInfo[0];
		$this->Y = $arrayInfo[1];

		if (mb_ereg("half", $strOption)) {
			$intX = floor($this->X / 2);
			$intY = floor($this->Y / 2);
		} else {
			$intX = $this->X;
			$intY = $this->Y;
		}

		return "<img "
			. "src='" . $this->All . "' "
			. "border='0' "
			. "width='" . $intX . "' "
			. "height='" . $intY . "' "
			. "alt='" . $strName . "' "
			. ">";
	}
}

function GetElement ($strName, $strBody) {
	$strRE = "<" . $strName . "[^>]*>(.*)</" . $strName . "[^>]*>";
	if (mb_eregi($strRE, $strBody, $arr))
		return $arr[1];
	else
		return "";
}
