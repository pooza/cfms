<?php
require_once(DBMS);
require_once("_class/date.inc");
require_once("_class/group.inc");
require_once("_class/idea.inc");
require_once("_class/user.inc");

class Project {
	var $ID;
	var $CreateDate;
	var $UpdateDate;
	var $AccessDate;
	var $Name;
	var $NameRead;
	var $Owner;
	var $Summary;
	var $Status;
	var $Error;

	function Project ($name) {
		global $db;

		$strSQL = "SELECT * FROM project WHERE (id='$name') OR (name='$name');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			if ($name != "")
				$this->Error = new Error("未登録のプロジェクトです。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $rec->id;
			$this->CreateDate = new Date($rec->create_date);
			$this->UpdateDate = new Date($rec->update_date);
			$this->AccessDate = new Date($rec->access_date);
			$this->Name = $rec->name;
			$this->NameRead = $rec->name_read;
			$this->Summary = $rec->summary;
			$this->Status = $rec->status;
			$this->Owner = new User($rec->owner);

			return true;
		}
	}

	function Touch () {
		global $db;

		$strSQL = "UPDATE project SET "
			. " access_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);
	}

	function Update ($user = null) {
		global $db;

		if (isset($user)) {
			if ($this->IsOwnedBy($user) == false)
				return new Error("プロジェクト情報の更新を許可されていません。", 1);
		}

		$this->Name = CleanStr($this->Name);
		$this->NameRead = CleanStr($this->NameRead, false, "C");

		$strSQL = "SELECT id FROM project "
			. "WHERE (name='" . $this->Name . "') "
			. " AND (id<>'" . $this->ID . "');";
		$rs = $db->query($strSQL);

		if (0 < $rs->NumRows) {
			return new Error("同名のプロジェクトがあります。", 1);
		}

		$strSQL = "UPDATE project SET "
			. " name='" . CleanStr($this->Name) . "', "
			. " name_read='" . CleanStr($this->NameRead, false, "C") . "', "
			. " update_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);

		$this->Touch();
		new Log("プロジェクト " . $this->Project->Name . " を更新しました。");
	}

	function IsOwnedBy ($user) {
		return (($user->ID != "guest") && ($this->Owner->ID == $user->ID));
	}

	function IsEnable ($strPriv, $class, $user) {
		global $db;

		if (($user->ID == "admin") || ($this->IsOwnedBy($user))) {
			return true;
		} else {
			$arrayClass = array();
			$arrayClass[] = "'IDEA'";
			$arrayClass[] = "'" . $class->ID . "'";
			if ($class->IsFile)
				$arrayClass[] = "'FILE'";

			$arrayCriteria = array();
			$arrayCriteria[] = "(project_id='" . $this->ID . "')";
			$arrayCriteria[] = "(user_id IN ('guest','@EVERYONE','" . $user->ID . "'))";
			$arrayCriteria[] = "(class_id IN (" . join(",", $arrayClass) . "))";

			switch ($strPriv) {
				case "READ":
					$arrayCriteria[] = "(priv IN ('READ','WRITE','ALL'))";
					break;
				case "WRITE":
					$arrayCriteria[] = "(priv IN ('WRITE','ALL'))";
					break;
				case "ALL":
					$arrayCriteria[] = "(priv='ALL')";
					break;
			}

			$strSQL = "SELECT priv FROM priv "
				. "WHERE " . join(" AND ", $arrayCriteria) . ";";
			$rs = $db->query($strSQL);
			return (0 < $rs->NumRows);
		}
		return true;
	}

	function Users () {
		global $db;

		$strSQL = "SELECT user_id AS id "
			. "FROM priv "
			. "WHERE (project_id='" . $this->ID . "') "
			. " AND (priv<>'NONE') "
			. "GROUP BY user_id "
			. "ORDER BY user_id;";
		$rs = $db->query($strSQL);
		$rs->Master = "igroup";

		return $rs;
	}

	function GetLabel () {
		if (mb_ereg("^@", $this->Name))
			return $this->Owner->ID . "のプライベート";
		else
			return $this->Name;
	}

	function Groups ($strCriteria = "igroup.id IS NOT NULL", $strOrder = "points DESC,igroup.access_date DESC") {
		global $db;

		$strSQL = "SELECT "
			. " igroup.id,"
			. " igroup.create_date,"
			. " igroup.update_date,"
			. " igroup.access_date,"
			. " igroup.owner,"
			. " igroup.name,"
			. " igroup.name_e,"
			. " igroup.name_read,"
			. " Sum(idea.point) AS points "
			. "FROM (igroup "
			. " LEFT JOIN attach ON igroup.id = attach.igroup_id) "
			. " LEFT JOIN idea ON attach.idea_id = idea.id "
			. "WHERE (igroup.project_id='" . $this->ID . "') "
			. " AND (" . $strCriteria . ") "
			. "GROUP BY igroup.id "
			. "ORDER BY " . $strOrder . ";";
		$rs = $db->query($strSQL);
		$rs->Master = "igroup";

		return $rs;
	}

	function CreateGroup ($strName, $strNameRead = "", $owner = null) {
		global $db;

		if (!isset($owner))
			$owner = $this->Owner;

		$strName = CleanStr($strName);
		$strNameRead = CleanStr($strNameRead);

		if ($strName == "") {
			return new Error("グループの名前が空欄です。", 1);
		} else if (mb_ereg("^@", $strName)) {
			return new Error("グループの名前が不正です。", 1);
		} else if ($this->IsEnable("WRITE", new IdeaClass("@GROUP"), $owner) == false) {
			return new Error("グループの作成を許可されていません。", 1);
		}

		$strSQL = "SELECT id FROM igroup "
			. "WHERE (project_id='" . $this->ID . "') "
			. " AND (name='" . $strName . "');";
		$rs = $db->query($strSQL);

		if (0 < $rs->NumRows) {
			return new Error("同名のグループがあります。", 1);
		}

		$strSQL = "INSERT INTO igroup "
			. "(create_date,update_date,access_date,owner,name,name_read,project_id) "
			. "VALUES ("
			. " " . Now("YmdHis") . ", "
			. " " . Now("YmdHis") . ", "
			. " " . Now("YmdHis") . ", "
			. " '" . $owner->ID . "', "
			. " '" . CleanStr($strName, false, "") . "', "
			. " '" . CleanStr($strNameRead, false, "C") . "', "
			. " '" . $this->ID . "');";
		$db->query($strSQL);

		$group = new Group($db->InsertID);
		new Log("プロジェクト " . $this->Name . " にグループ " . $group->Name . " を作成しました。");

		return $group;
	}

	function GetSpecialGroup ($strName) {
		global $db;

		$strSQL = "SELECT id FROM igroup "
			. "WHERE (project_id='" . $this->ID . "') "
			. " AND (name='@" . $strName . "');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows == 1) {
			$rec = $rs->FetchRecord();
			return new Group($rec->id);
		} else {
			return null;
		}
	}
}

$hashProjectStatus = array(
	"FIX" => "完了",
	"ACTIVE" => "進行中",
	"PENDING" => "保留");
?>
