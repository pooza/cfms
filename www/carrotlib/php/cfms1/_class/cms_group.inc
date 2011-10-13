<?php
require_once("_class/group.inc");

class CommonsGroup extends Group {
	var $TermDate;
	var $SortMethod;

	function CommonsGroup ($intID) {
		global $db;

		$strSQL = "SELECT * FROM igroup WHERE (id='$intID');";
		$rs = $db->query($strSQL);

		if ($rs->NumRows != 1) {
			$this->Error = new Error("未登録のフォルダです。", 1);
		} else {
			$rec = $rs->FetchRecord();
			$this->ID = $rec->id;
			$this->CreateDate = new Date($rec->create_date);
			$this->UpdateDate = new Date($rec->update_date);
			$this->AccessDate = new Date($rec->access_date);
			$this->TermDate = new Date($rec->term_date);
			$this->Name = $rec->name;
			$this->NameRead = $rec->name_read;
			$this->Owner = new User($rec->owner);
			$this->Project = new Project($rec->project_id);
			$this->SortMethod = $rec->sort_method;
			//$this->Touch();

			return true;
		}
	}

	function Update () {
		global $db;

		$this->Name = CleanStr($this->Name);
		$this->NameRead = CleanStr($this->NameRead, false, "C");

		$strSQL = "SELECT id FROM igroup "
			. "WHERE (project_id='" . $this->Project->ID . "') "
			. " AND (name='" . $this->Name . "') "
			. " AND (id<>'" . $this->ID . "');";
		$rs = $db->query($strSQL);
		if (0 < $rs->NumRows) {
			return new Error("同名のフォルダがあります。", 1);
		}

		if ($this->TermDate->IsInit()) {
			$strTermDate = "NULL";
		} else if ($this->TermDate->IsValid() == false) {
			return new Error("期限が不正な日付です。", 1);
		} else if ($this->TermDate->IsAgo(Now())) {
			return new Error("期限が過去の日付です。", 1);
		} else {
			$strTermDate = "'" . $this->TermDate->Format("YmdHis") . "'";
		}

		$strSQL = "UPDATE igroup SET "
			. " name='" . CleanStr($this->Name) . "', "
			. " name_read='" . CleanStr($this->NameRead, false, "C") . "', "
			. " sort_method='" . $this->SortMethod . "', "
			. " term_date=" . $strTermDate . ", "
			. " update_date=" . Now("YmdHis") . " "
			. "WHERE id='" . $this->ID . "';";
		$db->query($strSQL);

		$this->Touch();
		new Log("案件 " . $this->Project->Name . " のフォルダ " . $this->Name . " を更新しました。");
	}

	function GetColor ($strType = "") {
		if ($strType == "idea") {
			switch ($this->ID % 6) {
				case 0:
					return "#f0725a";
				case 1:
					return "#70bc5a";
				case 2:
					return "#2c73bb";
				case 3:
					return "#a478b3";
				case 4:
					return "#f6943b";
				case 5:
					return "#f29dc3";
			}
		} else {
			switch ($this->ID % 6) {
				case 0:
					return "#e61a2b";
				case 1:
					return "#4cb041";
				case 2:
					return "#0062af";
				case 3:
					return "#5e368a";
				case 4:
					return "#f48429";
				case 5:
					return "#ef87b6";
			}
		}
	}
}

$hashGroupOrder = array(
	"NAME" => "idea.name",
	"POINTD" => "idea.name",
	"CREATE" => "idea.create_date,idea.name",
	"CREATED" => "idea.create_date DESC,idea.name",
	"UPDATE" => "idea.update_date,idea.name",
	"UPDATED" => "idea.update_date DESC,idea.name",
	"TERM" => "idea.term_date,idea.name",
	"TERMD" => "idea.term_date DESC,idea.name");
?>
