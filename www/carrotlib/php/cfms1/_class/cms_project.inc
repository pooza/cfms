<?php
require_once(DBMS);
require_once("_class/project.inc");

class CommonsProject extends Project {
	var $TermDate;
	var $SortMethod;
	var $OrderID;

	function CommonsProject ($name) {
		global $db;

		$strSQL = "SELECT * FROM project WHERE (id='$name') OR (name='$name');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			if ($name != "")
				$this->Error = new Error("未登録の案件です。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $rec->id;
			$this->CreateDate = new Date($rec->create_date);
			$this->UpdateDate = new Date($rec->update_date);
			$this->AccessDate = new Date($rec->access_date);
			$this->TermDate = new Date($rec->term_date);
			$this->Name = $rec->name;
			$this->NameRead = $rec->name_read;
			$this->Summary = $rec->summary;
			$this->Status = $rec->status;
			$this->Owner = new User($rec->owner);
			$this->SortMethod = $rec->sort_method;
			$this->OrderID = $rec->order_id;
			//$this->Touch();

			return true;
		}
	}

	function Update () {
		global $db;

		$this->Name = CleanStr($this->Name);
		$this->NameRead = CleanStr($this->NameRead, false, "C");

		$strSQL = "SELECT id FROM project "
			. "WHERE (name='" . $this->Name . "') "
			. " AND (id<>'" . $this->ID . "');";
		$rs = $db->query($strSQL);
		if (0 < $rs->NumRows) {
			return new Error("同名の案件があります。", 1);
		}

		if ($this->TermDate->IsInit()) {
			$strTermDate = "NULL";
		} else if ($this->TermDate->IsValid() == false) {
			return new Error("納品日が不正な日付です。", 1);
		} else if ($this->TermDate->IsAgo(Now())) {
			return new Error("納品日が過去の日付です。", 1);
		} else {
			$strTermDate = "'" . $this->TermDate->Format("YmdHis") . "'";
		}

		$strSQL = "UPDATE project SET "
			. " name='" . CleanStr($this->Name) . "', "
			. " name_read='" . CleanStr($this->NameRead, false, "C") . "', "
			. " summary='" . CleanStr($this->Summary) . "', "
			. " term_date=" . $strTermDate . ", "
			. " status='" . $this->Status . "', "
			. " sort_method='" . $this->SortMethod . "', "
			. " order_id=" . bool2str($this->OrderID != "", $this->OrderID, "NULL") . ", "
			. " update_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);

		$this->Touch();
		new Log("案件 " . $this->Project->Name . " を更新しました。");
	}
}

$hashProjOrder = array(
	"NAME" => "igroup.name",
	"POINTD" => "igroup.name",
	"CREATE" => "igroup.create_date,igroup.name",
	"CREATED" => "igroup.create_date DESC,igroup.name",
	"UPDATE" => "igroup.update_date,igroup.name",
	"UPDATED" => "igroup.update_date DESC,igroup.name",
	"TERM" => "igroup.term_date,igroup.name",
	"TERMD" => "igroup.term_date DESC,igroup.name");
