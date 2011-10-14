<?php
require_once(DBMS);
require_once("_class/date.inc");
require_once("_class/idea.inc");
require_once("_class/project.inc");

class Group {
	var $ID;
	var $CreateDate;
	var $UpdateDate;
	var $AccessDate;
	var $Name;
	var $NameRead;
	var $Owner;
	var $Project;
	var $Error;

	function Group ($intID) {
		global $db;

		$strSQL = "SELECT * FROM igroup WHERE (id='$intID');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			$this->Error = new Error("未登録のグループです。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $rec->id;
			$this->CreateDate = new Date($rec->create_date);
			$this->UpdateDate = new Date($rec->update_date);
			$this->AccessDate = new Date($rec->access_date);
			$this->Name = $rec->name;
			$this->NameRead = $rec->name_read;
			$this->Owner = new User($rec->owner);
			$this->Project = new Project($rec->project_id);

			return true;
		}
	}

	function Touch () {
		global $db;

		$this->Project->Touch();

		$strSQL = "UPDATE igroup SET "
			. " access_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);
	}

	function Update ($user = null) {
		global $db;

		if (isset($user)) {
			if ($this->IsEnable("WRITE", $user) == false)
				return new Error("グループ情報の更新を許可されていません。", 1);
		}

		$this->Name = CleanStr($this->Name);
		$this->NameRead = CleanStr($this->NameRead, false, "C");

		$strSQL = "SELECT id FROM igroup "
			. "WHERE (project_id='" . $this->Project->ID . "') "
			. " AND (name='" . $this->Name . "') "
			. " AND (id<>'" . $this->ID . "');";
		$rs = $db->query($strSQL);
		if (0 < $rs->NumRows) {
			return new Error("同名のグループがあります。", 1);
		}

		$strSQL = "UPDATE igroup SET "
			. " name='" . CleanStr($this->Name) . "', "
			. " name_read='" . CleanStr($this->NameRead, false, "C") . "', "
			. " update_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);

		$this->Project->Update();
		$this->Touch();
		new Log("プロジェクト " . $this->Project->Name . " のグループ " . $this->Name . " を更新しました。");
	}

	function Delete ($user) {
		global $db;

		$rs = $this->Ideas();
		if (0 < $rs->NumRows) {
			return new Error("アイデアを含んだグループは削除出来ません。", 1);
		} else if ($this->IsEnable("WRITE", $user) == false) {
			return new Error("グループの削除を許可されていません。", 1);
		} else {
			$this->Project->Touch();

			$strSQL = "DELETE FROM igroup "
				. "WHERE id='" . $this->ID . "';";
			$db->query($strSQL);
		}
	}

	function Ideas ($strCriteria = "idea.id IS NOT NULL", $strOrder = "idea.point DESC") {
		global $db;

		$strSQL = "SELECT idea.id "
			. "FROM attach "
			. " INNER JOIN idea ON attach.idea_id = idea.id "
			. "WHERE (attach.igroup_id='" . $this->ID . "') "
			. " AND (" . $strCriteria . ") "
			. "ORDER BY " . $strOrder . ";";
		$rs = $db->query($strSQL);
		$rs->Master = "idea";

		return $rs;
	}

	function CreateIdea ($strName, $strNameRead = "", $class = null, $owner = null) {
		global $db;

		if (!isset($owner))
			$owner = $this->Owner;

		if (!isset($class))
			$class = new IdeaClass("IDEA");

		//$strName = CleanStr($strName);
		//$strNameRead = CleanStr($strNameRead);

		if ($strName == "") {
			return new Error("アイデアの名前が空欄です。", 1);
		} else if (mb_ereg("^@", $strName)) {
			return new Error("アイデアの名前が不正です。", 1);
		} else if ($this->Project->IsEnable("WRITE", $class, $owner) == false) {
			return new Error("アイデアの作成を許可されていません。", 1);
		} 

		$strSQL = "INSERT INTO idea "
			. "(create_date,update_date,access_date,owner,name,name_read,point,class_id) "
			. "VALUES ("
			. " " . Now("YmdHis") . ", "
			. " " . Now("YmdHis") . ", "
			. " " . Now("YmdHis") . ", "
			. " '" . $owner->ID . "', "
			. " '" . CleanStr($strName, false, "") . "', "
			. " '" . CleanStr($strNameRead, false, "C") . "', "
			. " '" . $class->Point . "', "
			. " '" . $class->ID . "');";
		$db->query($strSQL);
		$intID = $db->InsertID;
		$idea = new Idea($intID);
		$idea->CleanAttach();
		$idea->CreateAttach($this);
		$this->Update();

		new Log("プロジェクト " . $this->Project->Name . " 内のグループ " . $this->Name . " にアイデア " . $idea->Name . " を作成しました。");
		return $idea;
	}

	function IsOwnedBy ($user) {
		return (($user->ID != "guest") && ($this->Owner->ID == $user->ID));
	}

	function IsEnable ($strPriv, $user) {
		if (($user->ID == "admin") || ($this->IsOwnedBy($user))) {
			return true;
		} else {
			$hashPriv = array();
			$hashPriv["READ"] = "READ";
			$hashPriv["WRITE"] = "ALL";
			return $this->Project->IsEnable($hashPriv[$strPriv], new IdeaClass("GROUP"), $user);
		}
	}

	function IsNew () {
		$dateNow = Now();
		$timeNow = $dateNow->GetTimeStamp();
		$timeCreate = $this->CreateDate->GetTimeStamp();
		return (($timeNow - $timeCreate) < (60 * 60 * 24 * NEW_DATE));
	}

	function IsUpdated () {
		$dateNow = Now();
		$timeNow = $dateNow->GetTimeStamp();
		$timeUpdate = $this->UpdateDate->GetTimeStamp();
		return (($timeNow - $timeUpdate) < (60 * 60 * 24 * NEW_DATE));
	}

	function GetLabel () {
		switch ($this->Name) {
			case "@BOOKMARK":
				return "よく使うブックマーク";
				break;
			case "@TRAY":
				return "送られたブックマーク";
				break;
			case "@HIDDEN":
				return "隠すブックマーク";
				break;
			default:
				return $this->Name;
				break;
		}
	}

	function GetPoint () {
		global $db;

		$strSQL = "SELECT sum(idea.point) AS points "
			. "FROM attach "
			. " INNER JOIN idea ON attach.idea_id = idea.id "
			. "WHERE (attach.igroup_id='" . $this->ID . "');";
		$rs = $db->query($strSQL);
		$rec = $rs->FetchRecord();

		return (int)$rec->points;
	}

	function FormatIsNew () {
		if ($this->IsNew()) {
			return "<span class='alert'>New!</span>";
		} else if ($this->IsUpdated()) {
			return "<span class='notice'>Updated</span>";
		} else {
			return "";
		}
	}
}
