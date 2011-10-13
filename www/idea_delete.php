<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");
require_once("_class/idea.inc");

$proj = new CommonsProject($_SESSION["p"]);
$idea = new Idea($_GET["idea"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $idea->Error->ErrorLevel) {
	$idea->Error->Show();
} else if ($idea->IsEnable("WRITE", $app->LoginUser) == false) {
	$err = new Error("ファイルを更新する権限はありません。", 1);
	$err->Show();
}

$idea->Delete($app->LoginUser);
header("Location: project.php");
