<?php
if (isset($db))
	require_once("_class/log.inc");

class SeparatedFile extends File {
	var $FieldSeparator = ",";
	var $Quarted = false;

	function Put ($arrayFields) {
		if ($this->Quarted) {
			foreach ($arrayFields as $name => $value) {
				$arrayFields[$name] = "\"" . $value . "\"";
			}
		}
		$str = join($arrayFields, $this->FieldSeparator);
		$str = mb_ereg_replace("\"+$", "\"", $str);
		if(!mb_ereg("^\"+$", $str))
			File::Put($str);
	}

	function Get () {
		$array = explode($this->FieldSeparator, File::Get());
		if ($this->Quarted) {
			foreach ($array as $name => $value) {
				$array[$name] = mb_ereg_replace("\r", "", $value);
				$array[$name] = substr($value, 1, strlen($value) - 2);
			}
		}
		return $array;
	}
}

class BinaryFile extends File {
	function Get () {
		return fread($this->fp, $this->GetSize()); 
	}
}

class File {
	var $Path;
	var $Opened = false;
	var $Mode = null;
	var $LineSeparator = "\n";
	var $Line;
	var $LinePrev;
	var $fp;

	function File ($strPath) {
		$this->Path = $strPath;
	}

	function Open ($strMode = "r") {
		$this->fp = fopen($this->Path, $strMode);

		if ($this->fp != "") {
			$this->Opened = true;
			$this->Mode = $strMode;
			if (isset($db) && (DEBUG == true)) {
				new Log("ファイル " . $strPath . " を開きました。");
			}

			return true;
		} else {
			$this->Opened = false;
			$this->Mode = null;
			if (isset($db))
				return new Error("ファイル " . $strPath . " を開けませんでした。", 3);
			else
				return false;
		}
	}

	function Close () {
		$this->Opened = false;
		$this->Mode = null;

		fclose($this->fp);
		if (isset($db) && (DEBUG == true)) {
			new Log("ファイル " . $strPath . " を閉じました。");
		}
	}

	function Put ($str = "") {
		if ($this->Opened && mb_ereg("^[wa]\+?$", $this->Mode)) {
			flock($this->fp, LOCK_EX);
			fputs($this->fp, $str . $this->LineSeparator);
			flock($this->fp, LOCK_UN);
		} 
	}

	function Get ($intLength = 4096) {
		if ($this->EOF())
			return "";
		else {
			$this->LinePrev = $this->Line;
			flock($this->fp, LOCK_SH);
			$this->Line = fgets($this->fp, $intLength);
			flock($this->fp, LOCK_UN);
			$this->Line = mb_ereg_replace("\r", "", $this->Line);
			return $this->Line;
		}
	}

	function EOF () {
		return feof($this->fp);
	}

	function GetSize () {
		return filesize($this->Path);
	}

	function FormatSize() {
		$intSize = $this->GetSize();
		if ((1024 * 1024 * 1024 * 2) < $intSize) {
			return number_format($intSize / (1024 * 1024 * 1024)) . "G";
		} else if ((1024 * 1024 * 2) < $intSize) {
			return number_format($intSize / (1024 * 1024)) . "M";
		} else if ((1024 * 2) < $intSize) {
			return number_format($intSize / 1024) . "K";
		} else {
			return number_format($intSize);
		}
	}
}
