<?php
require_once(DBMS);
require_once("_class/file.inc");
require_once("_class/group.inc");

class Idea {
	var $ID;
	var $CreateDate;
	var $UpdateDate;
	var $AccessDate;
	var $TermDate;
	var $Name;
	var $NameRead;
	var $Point;
	var $Summary;
	var $Body;
	var $Status;
	var $Owner;
	var $Class;
	var $Project;
	var $Error;

	function Idea ($intID) {
		global $db;

		$strSQL = "SELECT * FROM idea WHERE (id='" . $intID . "');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			if ($intID != "")
				$this->Error = new Error("未登録のアイデアです。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $rec->id;
			$this->CreateDate = new Date($rec->create_date);
			$this->UpdateDate = new Date($rec->update_date);
			$this->AccessDate = new Date($rec->access_date);
			$this->TermDate = new Date($rec->term_date);
			$this->Name = $rec->name;
			$this->NameRead = $rec->name_read;
			$this->Point = $rec->point;
			$this->Summary = $rec->summary;
			$this->Body = $rec->body;
			$this->Status = $rec->status;
			$this->Owner = new User($rec->owner);
			$this->Class = new IdeaClass($rec->class_id);
			$this->Project = new Project($rec->project_id);
			//$this->Touch();
			return true;
		}
	}

	function Touch ($boolInc = true) {
		global $db;

		$rs = $this->Groups();
		while ($rec =$rs->FetchRecord()) {
			$group = new Group($rec->id);
			$group->Touch();
		}

		$strSQL = "UPDATE idea SET "
			. " access_date=" . Now("YmdHis") . ","
			. " point=point+" . bool2str($boolInc, 1, 0) . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);
	}

	function Update ($user = null) {
		global $db;

		if (isset($user)) {
			if ($this->IsEnable("WRITE", $user) == false)
				return new Error("アイデアの削除を許可されていません。", 1);
		}

		$strSQL = "UPDATE idea SET "
			. " name='" . CleanStr($this->Name) . "', "
			. " name_read='" . CleanStr($this->NameRead, false, "C") . "', "
			. " summary='" . CleanStr($this->Summary) . "', "
			. " body='" . CleanStr($this->Body) . "', "
			. " update_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);
		$this->Touch(false);

		$rs = $this->Groups();
		while ($rec =$rs->FetchRecord()) {
			$group = new Group($rec->id);
			$group->Update();
		}

		new Log("アイデア " . $this->Name . " を更新しました。");
	}

	function Delete ($user = null) {
		global $db;

		if ($this->IsEnable("WRITE", $user) == false) {
			return new Error("アイデアの削除を許可されていません。", 1);
		}

		if ($this->Class->IsFile) {
			$strFileName = $this->GetPath();
			if (file_exists($strFileName))
				unlink($strFileName);
		}

		$this->CleanAttach();
		$strSQL = "DELETE FROM idea "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);

		$rs = $this->Groups();
		while ($rec =$rs->FetchRecord()) {
			$group = new Group($rec->id);
			$group->Update();
		}

		new Log("アイデア " . $this->Name . " を削除しました。");
	}

	function Groups () {
		global $db;

		$strSQL = "SELECT igroup_id as id "
			. "FROM attach "
			. "WHERE (idea_id='" . $this->ID . "') "
			. "ORDER BY id;";
		$rs = $db->query($strSQL);
		$rs->Master = "igroup";

		return $rs;
	}

	function CreateAttach ($group) {
		global $db;

		$this->Touch(false);

		$strSQL = "INSERT INTO attach (igroup_id,idea_id) "
			. "VALUES ("
			. " '" . $group->ID . "',"
			. " '" . $this->ID . "');";
		$db->query($strSQL);
	}

	function CleanAttach () {
		global $db;

		$this->Touch(false);

		$strSQL = "DELETE FROM attach "
			. "WHERE idea_id='" . $this->ID . "';";
		$db->query($strSQL);
	}

	function IsEnable ($strPriv, $user) {
		if (($user->ID == "admin") || ($this->IsOwnedBy($user))) {
			return true;
		} else {
			$hashPriv = array();
			$hashPriv["READ"] = "READ";
			$hashPriv["WRITE"] = "ALL";

			$rs = $this->Groups();
			while ($rec = $rs->FetchRecord()) {
				$group = new Group($rec->id);
				if ($group->Project->IsEnable($hashPriv[$strPriv], $this->Class, $user))
					return true;
			}

			return false;
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

	function IsOwnedBy ($user) {
		return (($user->ID != "guest") && ($this->Owner->ID == $user->ID));
	}

	function GetPath () {
		if ($this->Class->IsFile) {
			return STORAGE_PATH . sprintf("%010d", $this->ID) . ".dat";
		}
	}

	function GetFile () {
		if ($this->Class->IsFile) {
			return new BinaryFile($this->GetPath());
		}
	}

	function GetW () {
		$array = GetImageSize($this->GetPath());
		return $array[0];
	}

	function GetH () {
		$array = GetImageSize($this->GetPath());
		return $array[1];
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

	function FormatImageSize () {
		return "W" . $this->GetW() . " x H" . $this->GetH();
	}
}

class IdeaClass {
	var $ID;
	var $Name;
	var $Description;
	var $Point;
	var $IsFile;
	var $Error;

	function IdeaClass ($strID) {
		global $db;

		$strSQL = "SELECT * FROM class WHERE (id='" . $strID . "');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			if ($strID != "")
				$this->Error = new Error("未登録のクラスです。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $rec->id;
			$this->Name = $rec->name;
			$this->Description = $rec->description;
			$this->Point = $rec->point;
			$this->IsFile = ($rec->isfile == "TRUE");
			return true;
		}
	}
}
