<?php
require_once(DBMS);
require_once("_class/smtp.inc");

class Log {
	var $Description;
	var $ErrorLevel;
	var $ID;

	function Log ($strDesc, $intErrorLevel = 0) {
		global $db;

		$this->Description = $strDesc;
		$this->ErrorLevel = $intErrorLevel;

		$strSQL = "INSERT INTO log_system "
			. "(log_date,error_level,description,script,remote_addr,remote_host)"
			. "VALUES ("
			. date("YmdHis") . ","
			. $this->ErrorLevel . ","
			. " '" . $this->Description . "',"
			. " '" . $_SERVER["SCRIPT_FILENAME"] . "',"
			. " '" . $_SERVER["REMOTE_ADDR"] . "',"
			. " '" . gethostbyaddr($_SERVER["REMOTE_ADDR"]) . "');";
		$db->query($strSQL);

		$this->ID = $db->InsertID;
	}
}

class Error extends Log {
	var $LinkHref = "javascript:history.back()";
	var $LinkLabel = "前のページに戻る";

	function Show ($strTemplate = null) {
		$hashHeading = array(
			0 => "",
			1 => "", //ワーニング
			2 => "エラーが発生しました。",
			3 => "重大なエラーが発生しました。");

		define("NO_SHORTCUT", "");
		include("_header.inc");
		
		if (isset($strTemplate)) {
			print $hashHeading[$this->ErrorLevel];
			$strHeading = $hashHeading[$this->ErrorLevel];
			$strBody = $this->Description;
			include ($strTemplate);
		} else {
?>
<h3 class='alert'><?= $hashHeading[$this->ErrorLevel] ?></h3>
<p><?= $this->Description ?></p>
<?				if (isset($this->LinkLabel)) { ?>
<p><a href='<?= $this->LinkHref ?>'><?= $this->LinkLabel ?></a></p>
<?				} ?>
<?php
		}
		include("_footer.inc");
		exit();
	}

	function SendMail() {
		$hash = array(
			0 => 5,
			1 => 3,
			2 => 2,
			3 => 1);

		$smtp = new SMTP();
		$smtp->From = new MailAddress(ADMIN_EMAIL);
		$smtp->To = new MailAddress(ADMIN_EMAIL);
		$smtp->Subject = "[" . APP_NAME . "] 自動障害報告";
		$smtp->Priority = $hash[$this->ErrorLevel];
		$smtp->Body = "リモートホスト： " . gethostbyaddr($_SERVER["REMOTE_ADDR"]) . "\n"
			. "ブラウザ： " . $_SERVER["HTTP_USER_AGENT"] . "\n"
			. "スクリプト： " . $_SERVER["SCRIPT_FILENAME"] . "\n\n"
			. $this->Description;
		$smtp->Send();
		$smtp->Close();
	}

	function Close() {
		// セッションを強制的に破棄
		session_start();
		session_destroy();
?>
<html>
<head>
<title></title>
</head>
<body>
<script language='JavaScript'><!--
window.close();
// -->
</script>
</body>
</html>
<?php
		exit();
	}
}
