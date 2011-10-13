<?php
require_once(DBMS);
require_once("_class/user.inc");

class Application {
	var $LoginUser;
	var $News;

	function Application () {
		global $_COOKIE;

		session_start();
		srand(time()); // 乱数を初期化

		$this->LoginUser = new User($_COOKIE["u"]);
	}

	function SetLoginUser ($user) {
		setcookie("u", 0, -1);
		setcookie("p", 0, -1);
		setcookie("u", $user->ID);
		setcookie("p", md5($user->Password));
		$this->LoginUser = $user;
	}

	function IdeaClasses ($strCriteria = "id is NOT NULL") {
		global $db;

		$strSQL = "SELECT id FROM class "
			. "WHERE (" . $strCriteria . ") "
			. "ORDER BY id;";
		$rs = $db->query($strSQL);
		$rs->Master = "class";

		return $rs;
	}
}

$hashOrder = array(
	"NAME" => "名前順",
	"CREATE" => "作成日順",
	"CREATED" => "作成日降順",
	"UPDATE" => "更新日順",
	"UPDATED" => "更新日降順",
	"TERM" => "納品日順",
	"TERMD" => "納品日降順");
?>
