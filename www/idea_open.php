<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");
require_once("_class/file.inc");
require_once("_class/idea.inc");

if (isset($_GET["idea"])) {
	$_SESSION["i"] = $_GET["idea"];
}

$proj = new CommonsProject($_SESSION["p"]);
$idea = new Idea($_SESSION["i"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $idea->Error->ErrorLevel) {
	$idea->Error->Show();
} else if ($idea->IsEnable("READ", $app->LoginUser) == false) {
	$err = new Error("ファイルを閲覧する権限はありません。", 1);
	$err->Show();
}

$idea->Touch();

header("Pragma: private");
header("Cache-Control: private");

$file = $idea->GetFile();
mb_http_output("pass");
header("Content-type: application/octet-stream");
header("Content-size: " . $file->GetSize());
header("Content-disposition: attachment; filename=" . $idea->Body);
$file->Open();
print($file->Get());
$file->Close();
