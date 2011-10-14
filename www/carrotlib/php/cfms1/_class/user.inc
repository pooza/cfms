<?php
require_once(DBMS);
require_once("_class/date.inc");
require_once("_class/project.inc");
require_once("_class/smtp.inc");

class User {
	var $ID;
	var $CreateDate;
	var $UpdateDate;
	var $AccessDate;
	var $Password;
	var $Name;
	var $NameRead;
	var $EMail;
	var $Company;
	var $Section;
	var $Title;
	var $Status;
	var $Error;

	function User ($strID) {
		global $db;

		$strSQL = "SELECT * FROM user WHERE (id='" . $strID . "');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			if ($strID != "")
				$this->Error = new Error("未登録のユーザーです。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $strID;
			$this->CreateDate = new Date($rec->create_date);
			$this->UpdateDate = new Date($rec->update_date);
			$this->AccessDate = new Date($rec->access_date);
			$this->Password = $rec->password;
			$this->Name = $rec->name;
			$this->NameRead = $rec->name_read;
			$this->Company = $rec->company;
			$this->Section = $rec->section;
			$this->Title = $rec->title;
			$this->Status = $rec->status;
			$this->EMail = new MailAddress($rec->email, $this->Name);
			//$this->Touch();
		}
	}

	function Touch () {
		global $db;

		$strSQL = "UPDATE user SET "
			. " access_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);
	}

	function Update () {
		global $db;

		$strSQL = "UPDATE user SET "
			. " name='" . CleanStr($this->Name) . "', "
			. " name_read='" . CleanStr($this->NameRead, false, "C") . "', "
			. " company='" . CleanStr($this->Company) . "', "
			. " section='" . CleanStr($this->Section) . "', "
			. " title='" . CleanStr($this->Title) . "', "
			. " status='" . $this->Status . "', "
			. " email='" . CleanStr($this->EMail->Addr) . "', "
			. " update_date=" . Now("YmdHis") . ", "
			. " access_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);
	}

	function Auth ($strPassword) {
		if ($this->Status == "LEAVE")
			return false;
		else
			return ($this->Password == $strPassword) || (md5($this->Password) == $strPassword);
	}

	// ポイント順にソートするように変更
	function Projects ($strCriteria = "project.id IS NOT NULL", $strOrder = "update_date DESC") {
		global $db;

		if ($this->ID == "admin") {
			$strSQL = "SELECT project.id "
				. "FROM project "
				. "WHERE (" . $strCriteria . ") "
				. "ORDER BY " . $strOrder . ";";
		} else {
			$strSQL = "SELECT project.id "
				. "FROM project "
				. " LEFT JOIN priv ON project.id = priv.project_id "
				. "WHERE (" . $strCriteria . ") "
				. " AND (priv.user_id IN ('guest','" . $this->ID . "')) "
				. "GROUP BY project.id "
				. "ORDER BY " . $strOrder . ";";
		}
		$rs = $db->query($strSQL);
		$rs->Master = "project";
		return $rs;
	}

	function Format ($boolTiny = false) {
		if ($this->Company != "")
			$str .= $this->Company . " ";

		if (($this->Section != "") && !$boolTiny)
			$str .= $this->Section . " ";

		if ($this->Name == "")
			$str .= $this->ID . " ";
		else
			$str .= $this->Name . " ";

		$str .= " <code>&lt;<a href='mailto:" . $this->EMail->Addr . "'>" . $this->EMail->Addr . "</a>&gt;</code>";

		return $str;
	}

	function GetPrivateProject() {
		return new Project("@P_" . $this->ID);
	}
}
