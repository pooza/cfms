<?php
if (isset($db))
	require_once("_class/log.inc");

define("SEC_TIMEOUT", 5); // タイムアウト秒
define("NOF_RETRY", 5); // 接続試行回数

class Socket {
	var $Host;
	var $Port;
	var $Connected = false;
	var $fp;

	function Socket ($strHost, $intPort) {
		global $db;

		$i = 0;
		while($i ++ < NOF_RETRY) {
			$this->fp = fsockopen($strHost, $intPort);

			if ($this->fp != "") {
				if (isset($db))
					new Log("ホスト " . $strHost . " に接続しました。");

				socket_set_timeout($this->fp, SEC_TIMEOUT);
				$this->Host = $strHost;
				$this->Port = $intPort;
				$this->Connected = true;
				return true;
			} else {
				continue;
			}
		}

		if (isset($db))
			new Error("ホスト " . $strHost . " に接続出来ません。", 3);

		return false;
	}

	function Put ($str = "") {
		if ($this->Connected) {
			$str .= "\r\n";
			fputs($this->fp, $str);
		}
	}

	function Get ($intLength = 4096) {
		if ($this->EOF())
			return "";
		else
			return fgets($this->fp, $intLength);
	}

	function EOF () {
		return feof($this->fp);
	}

	function Close () {
		global $db;

		if ($this->Connected) {
			if (isset($db))
				new Log("ホスト " . $this->Host . " から切断しました。");

			fclose($this->fp);
			$this->Connected = false;
		}
	}
}
