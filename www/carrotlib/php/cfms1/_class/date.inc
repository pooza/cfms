<?php
require_once("_func.inc");
require_once("_class/socket.inc");

class Date {
	var $Y = 0;
	var $M = 0;
	var $D = 0;
	var $Hour = 0;
	var $Min = 0;
	var $Sec = 0;

	function Date ($strDate = null) {
		if (!isset($strDate)) {
		} else if (mb_ereg("^[0-9]+$", $strDate)) { //TIMESTAMP型
			$this->Y = (int)substr($strDate, 0, 4);
			$this->M = (int)substr($strDate, 4, 2);
			$this->D = (int)substr($strDate, 6, 2);
			$this->Hour = (int)substr($strDate, 8, 2);
			$this->Min = (int)substr($strDate, 10, 2);
			$this->Sec = (int)substr($strDate, 12, 4);
		} else { 
			$this->Y = (int)substr($strDate, 0, 4);
			$this->M = (int)substr($strDate, 5, 2);
			$this->D = (int)substr($strDate, 8, 2);
			$this->Hour = (int)substr($strDate, 11, 2);
			$this->Min = (int)substr($strDate, 14, 2);
			$this->Sec = (int)substr($strDate, 17, 2);
		}
	}

	function IsValid () {
		$dateLast = $this->LastDateOfMonth();

		return !(($this->Y < 1) || (9999 < $this->Y)
			|| ($this->M < 1) || (12 < $this->M)
			|| ($this->D < 1) || ($dateLast->D < $this->D)
			|| ($this->Hour < 0) || (23 < $this->Hour)
			|| ($this->Min < 0) || (59 < $this->Min)
			|| ($this->Sec < 0) || (59 < $this->Sec));
	}

	function IsInit () {
		return  (($this->Y == 0) && ($this->M == 0) && ($this->D == 0));
	}

	function IsAgo ($dateNow = null) {
		if (!isset($dateNow))
			$dateNow = Now();

		if ($this->Y < $dateNow->Y)
			return true;
		else if (($this->Y == $dateNow->Y)
			&& ($this->M < $dateNow->M))
			return true;
		else if (($this->Y == $dateNow->Y)
			&& ($this->M == $dateNow->M)
			&& ($this->D < $dateNow->D))
			return true;
		else if (($this->Y == $dateNow->Y)
			&& ($this->M == $dateNow->M)
			&& ($this->D == $dateNow->D)
			&& ($this->Hour < $dateNow->Hour))
			return true;
		else if (($this->Y == $dateNow->Y)
			&& ($this->M == $dateNow->M)
			&& ($this->D == $dateNow->D)
			&& ($this->Hour == $dateNow->Hour)
			&& ($this->Min < $dateNow->Min))
			return true;
		else if (($this->Y == $dateNow->Y)
			&& ($this->M == $dateNow->M)
			&& ($this->D == $dateNow->D)
			&& ($this->Hour == $dateNow->Hour)
			&& ($this->Min == $dateNow->Min)
			&& ($this->Sec < $dateNow->Sec))
			return true;
		else
			return false;
	}

	function LastDateOfMonth () {
		$array = array(0, 31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		$dateLast = new Date();
		$dateLast->Y = $this->Y;
		$dateLast->M = $this->M;
	
		if ($this->M == 2) {
			if ($this->IsLeap())
				$dateLast->D = 29;
			else
				$dateLast->D = 28;
		} else
			$dateLast->D = $array[$this->M];

		return $dateLast;
	}

	function IsLeap () {
		if (($this->Y % 4) == 0) {
			if (($this->Y % 400) == 0)
				return true;
			else if (($this->Y % 100) == 0)
				return false;
			else
				return true;
		} else
			return false;
	}

	function GetAge() {
		$dateNow = Now();

		$intY = $dateNow->Y - $this->Y;
		if ($dateNow->M < $this->M) {
			$intY --;
		} else if (($dateNow->M == $this->M) && ($dateNow->D < $this->D)) {
			$intY --;
		}
		return $intY;
	}

	function GetWeekday () {
		// Zellerの公式による
		$y = $this->Y;
		$m = $this->M - 2;
		$d = $this->D;

		if ($m < 0) {
			$m += 12;
			$y --;
		}

		$n = $y + ($y / 4) - ($y / 100) + ($y / 400) - ($y / 4000) + ((13 * $m - 1) / 5) + $d;
		$hash = array("日", "月", "火", "水", "木", "金", "土");
		return $hash[$n % 7];
	}

	function GetTimeStamp () {
		return mktime($this->Hour, $this->Min, $this->Sec, $this->M, $this->D, $this->Y);
	}

	function Format ($strFormat = "YmdHis", $boolForce = false) {
		if ($this->IsInit() && ($boolForce == false))
			return "";

		$str = $strFormat;
		$hash = array(
			"Y" => sprintf("%04d", $this->Y),
			"y" => substr(sprintf("%04d", $this->Y), 2, 2),
			"m" => sprintf("%02d", $this->M),
			"n" => $this->M,
			"d" => sprintf("%02d", $this->D),
			"j" => $this->D,
			"w" => $this->GetWeekday(),
			"H" => sprintf("%02d", $this->Hour),
			"i" => sprintf("%02d", $this->Min),
			"s" => sprintf("%02d", $this->Sec));

		foreach ($hash as $strSymbol => $strValue) {
			$str = str_replace($strSymbol, $strValue, $str);
		}

		return $str;
	}
}

function Now ($strFormat = null) {
	$timestamp = time();
	$date = new Date();
	$date->Y = (int)date("Y", $timestamp);
	$date->M = (int)date("m", $timestamp);
	$date->D = (int)date("d", $timestamp);
	$date->Hour = (int)date("H", $timestamp);
	$date->Min = (int)date("i", $timestamp);
	$date->Sec = (int)date("s", $timestamp);

	if (isset($strFormat))
		return $date->Format($strFormat);
	else
		return $date;
}

// 以下、利用を推奨しない関数

function MysqlDate2Timestamp ($date, $boolTimestamp = false) {
	if (($date == 0) || ($date == "")) {
		return null;
	} else if ($boolTimestamp) {
		$strDate = substr($date, 0, 4) . "/"
			. substr($date, 4, 2) . "/"
			. substr($date, 6, 2) . " "
			. substr($date, 8, 2) . ":"
			. substr($date, 10, 2) . ":"
			. substr($date, 12, 4);
		return strtotime($strDate);
	} else {
		return strtotime($date);
	}
}

function FormatDate ($date) {
	$hashDay = array("日", "月", "火", "水", "木", "金", "土");
	return (date("Y年 n月j日", $date) . " (" . $hashDay[date("w", $date)] . ")");
}

function FormatYM ($ym) {
	return substr($ym, 0, 4) . "-" . substr($ym, 4, 2);
}
