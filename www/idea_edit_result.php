<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_project.inc");
require_once("_class/cms_group.inc");
require_once("_class/idea.inc");

$proj = new CommonsProject($_SESSION["p"]);
$idea = new Idea($_SESSION["i"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $idea->Error->ErrorLevel) {
	$idea->Error->Show();
} else if ($idea->IsEnable("WRITE", $app->LoginUser) == false) {
	$err = new Error("ファイル情報を更新する権限はありません。", 1);
	$err->Show();
}

$idea->Name = $_POST["name"];
$idea->Summary = $_POST["summary"];
$idea->TermDate->Y = $_POST["term_y"];
$idea->TermDate->M = $_POST["term_m"];
$idea->TermDate->D = $_POST["term_d"];

$err = $idea->Update();
if (0 < $err->ErrorLevel)
	$err->Show();

$idea->CleanAttach();
$idea->CreateAttach(new CommonsGroup($_POST["group"]));

header("Location: project.php");
