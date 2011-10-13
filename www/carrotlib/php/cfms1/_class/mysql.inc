<?php
class Database {
	var $ID;
	var $AffectedRows;
	var $InsertID;
	var $rs;
	var $Host;
	var $UserName;
	var $Password;
	var $DBName;

	function Database () {
		$this->ID = mysql_connect(DB_HOST, DB_USER, DB_PWD);
		mysql_select_db(DB_NAME, $this->ID);

		$this->Host = DB_HOST;
		$this->UserName = DB_USER;
		$this->Password = DB_PWD;
		$this->DBName = DB_NAME;
		$this->query('set names utf8');
	}

	function close () {
		mysql_close($this->ID);
	}

	function query ($strSQL) {
		if (mb_eregi("^SELECT", $strSQL)) {
			return new Recordset($strSQL);
		} else {
			if (mysql_query($strSQL, $this->ID)) {
				$this->InsertID = mysql_insert_id($this->ID);
				$this->AffectedRows = mysql_affected_rows($this->ID);
				return true;
			} else {
				if (DEBUG == true)
					new Error($strSQL, 1);
				return false;
			}
		}
	}

	function BeginTrans () {
		$this->query("begin;");
	}

	function Commit () {
		$this->query("commit;");
	}

	function Rollback () {
		$this->query("rollback;");
	}
}

class Recordset {
	var $ID;
	var $QueryString;
	var $NumRows;
	var $Master; //このレコードセットの参照先マスタテーブル

	function Recordset($strSQL) {
		global $db;

		$this->QueryString = $strSQL;

		if ($this->ID = mysql_query($this->QueryString, $db->ID)) { //代入に成功すればtrue
			$this->NumRows = mysql_num_rows($this->ID);
		} else {
			if (DEBUG == true) {
				new Error($this->QueryString, 1);
			}
			$this->NumRows = 0;
		}

		return $this->ID;
	}

	function FetchRecord() {
		return mysql_fetch_object($this->ID);
	}

	function Hash ($hash = null) {
		global $db;

		if (!isset($hash))
			$hash = array();

		while ($rec = $this->FetchRecord()) {
			if (isset($this->Master)) {
				$strSQL = "SELECT id,name "
					. "FROM " . $this->Master . " "
					. "WHERE (id='" . $rec->id . "');";
				$rs = $db->query($strSQL);

				if ($rs->NumRows == 1) {
					$recCurrent = $rs->FetchRecord();
					$hash[$recCurrent->id] = $recCurrent->name;
				}
			} else
				$hash[$rec->id] = $rec->id;
		}

		return $hash;
	}
}
