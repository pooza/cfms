<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");

$proj = new CommonsProject($_SESSION["p"]);
$group = new CommonsGroup($_SESSION["g"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $group->Error->ErrorLevel) {
	$group->Error->Show();
} else if ($group->IsEnable("WRITE", $app->LoginUser) == false) {
	$err = new Error("フォルダ情報を更新する権限はありません。", 1);
	$err->Show();
}

$group->Name = $_POST["name"];
$group->TermDate->Y = $_POST["term_y"];
$group->TermDate->M = $_POST["term_m"];
$group->TermDate->D = $_POST["term_d"];

$err = $group->Update();
if (0 < $err->ErrorLevel)
	$err->Show();

header("Location: project.php");
