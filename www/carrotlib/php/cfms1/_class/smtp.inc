<?php
require_once("_func.inc");
define("EMAIL_PATTERN", "^([0-9a-z_\.\-]+)@(([0-9a-z_\-]+\.)+[0-9a-z]+)$");

class MailAddress {
	var $Addr;
	var $Name;
	var $Account;
	var $Host;
	var $CarrierSuffix;

	function MailAddress ($strAddr, $strName = null) {
		$this->Addr = $strAddr;
		$this->Name = $strName;

		if (mb_eregi(EMAIL_PATTERN, $this->Addr, $arrayAddr)) {
			$this->Account = $arrayAddr[1];
			$this->Host = $arrayAddr[2];
		}

		if (mb_eregi("docomo\.ne\.jp$", $this->Addr))
			$this->CarrierSuffix = "i";
		else if (mb_eregi("ezweb\.ne\.jp$", $this->Addr))
			$this->CarrierSuffix = "ez";
		else if (mb_eregi("jp-.\.ne\.jp$", $this->Addr))
			$this->CarrierSuffix = "j";
		else
			$this->CarrierSuffix = "";
	}

	function IsValid ($boolCheckMX = true) {
		if (!mb_eregi(EMAIL_PATTERN, $this->Addr)) {
			return false;
		} else if (!getmxrr($this->Host, $arrayMX) && $boolCheckMX) {
			return false;
		} else {
			return true;
		}
	}

	function Format ($boolEncodeFlag = true) {
		if (isset($this->Name))
			if ($boolEncodeFlag)
				return mb_encode_mimeheader($this->Name) . " <" . $this->Addr . ">";
			else
				return $this->Name . " <" . $this->Addr . ">";
		else
			return $this->Addr;
	}
}

if (defined("MTA_TZ")) {
	if (isset($db))
		require_once("_class/log.inc");

	require_once("_class/socket.inc");

	class SMTP extends Socket {
		var $From;
		var $To;
		var $Subject;
		var $MessageID;
		var $ContentType = "text/plain";
		var $Priority = 3;
		var $Body;

		function SMTP ($strHost = MTA_HOST, $intPort = 25) {
			global $db;

			$i = 0;
			while($i ++ < NOF_RETRY) {
				$this->fp = fsockopen($strHost, $intPort);

				if ($this->fp == "")
					continue;
				else
					$this->Connected = true; // 接続フラグを仮に立てておく

				$this->Get();
				$this->Put("HELO " . $_SERVER['SERVER_NAME']);

				if (mb_ereg("^250", $this->Get())) {
					new Log("メールサーバ " . MTA_HOST . " に接続しました。");
					srand(time()); // Message-ID生成の為に、乱数を初期化
					socket_set_timeout($this->fp, SEC_TIMEOUT);
					$this->Host = $strHost;
					$this->Port = $intPort;
					return true;
				} else {
					$this->Connected = false;
					continue;
				}
			}

			if (isset($db))
				new Error("メールサーバ " . MTA_HOST . " に接続出来ません。", 3);

			return false;
		}

		function Send () {
			global $db;

			$i = 0;
			while ($i ++ < NOF_RETRY) {
				$this->Put("MAIL FROM:" . $this->From->Addr);
				if (mb_ereg("^250", $this->Get()) == false)
					continue;

				if (DEBUG == true) {
					$this->Put("RCPT TO:" . ADMIN_EMAIL);
				} else {
					$this->Put("RCPT TO:" . $this->To->Addr);
				}
				if (mb_ereg("^25[01]", $this->Get()) == false)
					continue;

				$this->Put("DATA");
				if (mb_ereg("^354", $this->Get()) == false)
					continue;

				$this->Put($this->FormatHeader());
				$this->Put($this->FormatBody());
				$this->Put(".");
				if (mb_ereg("^250", $this->Get())) {
					if (isset($db))
						new Log($this->To->Addr . " 宛のメール " . $this->MessageID . " を送信しました。");

					return true;
				} else
					continue;
			}

			if (isset($db))
				new Error($this->To->Addr . " への送信に失敗しました。", 2);

			return false;
		}

		function FormatHeader () {
			$this->MessageID = time() . rand(1000000, 9999999) . "@" . $_SERVER['SERVER_NAME'];

			return ("Date: " . strftime("%a, %d %b %Y %T ") . MTA_TZ . "\r\n"
				. "From: " . $this->From->Format() . "\r\n"
				. "To: " . $this->To->Format() . "\r\n"
				. "Subject: " . mb_encode_mimeheader($this->Subject) . "\r\n"
				. "Message-ID: " . $this->MessageID . "\r\n"
				. "Mime-Version: 1.0\r\n"
				. "Content-Type: " . $this->ContentType . "; charset=iso-2022-jp\r\n"
				. "Content-Transfer-Encoding: 7bit\r\n"
				. "X-Priority: " . $this->Priority . "\r\n"
				. "X-Mailer: " . APP_NAME_E . " " . APP_VER . "\r\n");
		}

		function FormatBody () {
			$str = mb_convert_kana($this->Body, "KV");
			$str = mb_convert_encoding($this->Body, "iso-2022-jp", "auto");
			$str = str_replace("\n", "\r\n", $str);
			return $str;
		}

		function Close () {
			global $db;

			if ($this->Connected) {
				if (isset($db))
					new Log("メールサーバ " . $this->Host . " から切断しました。");

				$this->Put("QUIT");
				fclose($this->fp);
				$this->Connected = false;
			}
		}
	}
}
