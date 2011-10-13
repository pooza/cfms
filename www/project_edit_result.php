<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_project.inc");

$proj = new CommonsProject($_SESSION["p"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if ($proj->IsOwnedBy($app->LoginUser) == false) {
	$err = new Error("案件情報を更新する権限はありません。", 1);
	$err->Show();
}

$proj->Name = $_POST["name"];
$proj->TermDate->Y = $_POST["term_y"];
$proj->TermDate->M = $_POST["term_m"];
$proj->TermDate->D = $_POST["term_d"];
$proj->Status = $_POST["status"];
$proj->Summary = $_POST["summary"];
$proj->OrderID = $_POST["order"];

$err = $proj->Update();
if (0 < $err->ErrorLevel)
	$err->Show();

header("Location: project.php");
